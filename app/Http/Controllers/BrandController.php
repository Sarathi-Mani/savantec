<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Constructor to apply middleware.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('XSS');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('brand_view')) {
            // Get filter parameters
            $search = $request->input('search');
            $status = $request->input('status');
            
            // Start query
            $brands = Brand::where('created_by', Auth::user()->creatorId())
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    });
                })
                ->when(isset($status) && $status !== '', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->orderBy('name', 'asc')
                ->get()
                ->map(function ($brand) {
                    // Get item count for each brand
                    $brand->item_count = Items::where('brand', $brand->name)
                        ->where('created_by', Auth::user()->creatorId())
                        ->count();
                    return $brand;
                });
            
            return view('brands.index', compact('brands'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('brand_add')) {
            return view('brands.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    if (\Auth::user()->can('brand_add')) {
        // Remove 'status' from validation - only validate name and description
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string|max:1000',
            // Remove status validation
        ], [
            'name.required' => __('Brand name is required'),
            'name.unique' => __('This brand name already exists'),
            'name.max' => __('Brand name cannot exceed 255 characters'),
            'description.max' => __('Description cannot exceed 1000 characters'),
            // Remove status messages
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->description = $request->description;
            // Status will be set automatically by migration default (true/1)
            // Or you can explicitly set it:
            // $brand->status = true; // Default active
            $brand->created_by = Auth::user()->creatorId();
            $brand->save();

            DB::commit();

            return redirect()->route('brands.index')->with('success', __('Brand created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('Failed to create brand. Please try again.'))
                ->withInput();
        }
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (\Auth::user()->can('brand_view')) {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return redirect()->route('brands.index')->with('error', __('Brand not found.'));
            }
            
            if ($brand->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Get items for this brand with pagination
            $items = Items::where('brand', $brand->name)
                ->where('created_by', Auth::user()->creatorId())
                ->with(['company', 'tax'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Get statistics
            $totalItems = Items::where('brand', $brand->name)
                ->where('created_by', Auth::user()->creatorId())
                ->count();
            
            $totalStock = Items::where('brand', $brand->name)
                ->where('created_by', Auth::user()->creatorId())
                ->sum('quantity');
            
            $totalValue = Items::where('brand', $brand->name)
                ->where('created_by', Auth::user()->creatorId())
                ->sum(DB::raw('quantity * purchase_price'));
            
            return view('brands.show', compact('brand', 'items', 'totalItems', 'totalStock', 'totalValue'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (\Auth::user()->can('brand_edit')) {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return redirect()->route('brands.index')->with('error', __('Brand not found.'));
            }
            
            if ($brand->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('brands.edit', compact('brand'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    if (\Auth::user()->can('brand_edit')) {
        $brand = Brand::find($id);
        
        if (!$brand) {
            return redirect()->route('brands.index')->with('error', __('Brand not found.'));
        }
        
        if ($brand->created_by != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        // Remove status from validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'description' => 'nullable|string|max:1000',
            // Remove status validation
        ], [
            'name.required' => __('Brand name is required'),
            'name.unique' => __('This brand name already exists'),
            'name.max' => __('Brand name cannot exceed 255 characters'),
            'description.max' => __('Description cannot exceed 1000 characters'),
            // Remove status messages
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $oldBrandName = $brand->name;
            
            $brand->name = $request->name;
            $brand->description = $request->description;
            // Don't update status automatically on edit
            $brand->save();
            
            // Update items with new brand name if name changed
            if ($oldBrandName != $request->name) {
                Items::where('brand', $oldBrandName)
                    ->where('created_by', Auth::user()->creatorId())
                    ->update(['brand' => $request->name]);
            }

            DB::commit();

            return redirect()->route('brands.index')->with('success', __('Brand updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('Failed to update brand. Please try again.'))
                ->withInput();
        }
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('brand_delete')) {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return redirect()->route('brands.index')->with('error', __('Brand not found.'));
            }
            
            if ($brand->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Check if brand is being used in items
            $itemCount = Items::where('brand', $brand->name)
                ->where('created_by', Auth::user()->creatorId())
                ->count();
            
            if ($itemCount > 0) {
                return redirect()->route('brands.index')->with('error', 
                    __('Cannot delete brand. It is being used in :count items.', ['count' => $itemCount]));
            }
            
            DB::beginTransaction();
            try {
                $brand->delete();
                
                DB::commit();
                
                return redirect()->route('brands.index')->with('success', __('Brand deleted successfully.'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('brands.index')->with('error', __('Failed to delete brand. Please try again.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Bulk update brand status.
     */
    public function bulkUpdate(Request $request)
    {
        if (\Auth::user()->can('brand_edit')) {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array',
                'ids.*' => 'exists:brands,id',
                'status' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => __('Invalid request data')
                ], 400);
            }

            DB::beginTransaction();
            try {
                $updatedCount = Brand::whereIn('id', $request->ids)
                    ->where('created_by', Auth::user()->creatorId())
                    ->update(['status' => $request->status]);

                DB::commit();

                $message = $request->status 
                    ? __(':count brands activated successfully.', ['count' => $updatedCount])
                    : __(':count brands deactivated successfully.', ['count' => $updatedCount]);

                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => __('Failed to update brands. Please try again.')
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => __('Permission denied.')
            ], 403);
        }
    }

    /**
     * Get brands for dropdown (AJAX).
     */
    public function getBrands(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            
            $brands = Brand::where('created_by', Auth::user()->creatorId())
                ->where('status', true)
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('name', 'asc')
                ->limit(50)
                ->get()
                ->map(function ($brand) {
                    return [
                        'id' => $brand->id,
                        'text' => $brand->name
                    ];
                });

            return response()->json($brands);
        }
    }

    /**
     * Check if brand name exists (AJAX).
     */
    public function checkBrandName(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'id' => 'nullable|exists:brands,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'valid' => false,
                    'message' => __('Invalid request')
                ]);
            }

            $query = Brand::where('name', $request->name)
                ->where('created_by', Auth::user()->creatorId());

            if ($request->id) {
                $query->where('id', '!=', $request->id);
            }

            $exists = $query->exists();

            return response()->json([
                'valid' => !$exists,
                'message' => $exists ? __('This brand name already exists.') : __('Brand name is available.')
            ]);
        }
    }

    /**
     * Export brands to CSV.
     */
    public function export()
    {
        if (\Auth::user()->can('brand_view')) {
            $brands = Brand::where('created_by', Auth::user()->creatorId())
                ->orderBy('name', 'asc')
                ->get();

            $fileName = 'brands_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            $callback = function() use ($brands) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for UTF-8
                fwrite($file, "\xEF\xBB\xBF");
                
                // Add CSV headers
                fputcsv($file, [
                    __('ID'),
                    __('Name'),
                    __('Slug'),
                    __('Description'),
                    __('Status'),
                    __('Items Count'),
                    __('Created By'),
                    __('Created At'),
                    __('Updated At')
                ]);
                
                // Add data rows
                foreach ($brands as $brand) {
                    $itemCount = Items::where('brand', $brand->name)
                        ->where('created_by', Auth::user()->creatorId())
                        ->count();
                    
                    $creator = $brand->creator ? $brand->creator->name : __('N/A');
                    
                    fputcsv($file, [
                        $brand->id,
                        $brand->name,
                        $brand->slug,
                        $brand->description ?? '',
                        $brand->status ? __('Active') : __('Inactive'),
                        $itemCount,
                        $creator,
                        $brand->created_at->format('Y-m-d H:i:s'),
                        $brand->updated_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Get brand statistics.
     */
    public function getStatistics()
    {
        if (\Auth::user()->can('brand_view')) {
            $totalBrands = Brand::where('created_by', Auth::user()->creatorId())->count();
            $activeBrands = Brand::where('created_by', Auth::user()->creatorId())->where('status', true)->count();
            $inactiveBrands = Brand::where('created_by', Auth::user()->creatorId())->where('status', false)->count();
            
            // Get top 5 brands by item count
            $topBrands = Brand::where('created_by', Auth::user()->creatorId())
                ->get()
                ->map(function ($brand) {
                    $brand->item_count = Items::where('brand', $brand->name)
                        ->where('created_by', Auth::user()->creatorId())
                        ->count();
                    return $brand;
                })
                ->sortByDesc('item_count')
                ->take(5)
                ->values();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_brands' => $totalBrands,
                    'active_brands' => $activeBrands,
                    'inactive_brands' => $inactiveBrands,
                    'top_brands' => $topBrands
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => __('Permission denied.')
            ], 403);
        }
    }
}