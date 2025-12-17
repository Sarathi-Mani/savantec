<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
        if (\Auth::user()->can('item_category_view')) {
            // Get filter parameters
            $search = $request->input('search');
            $status = $request->input('status');
            
            // Start query
            $categories = Category::where('created_by', Auth::user()->creatorId())->where('status',1)
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
                ->map(function ($category) {
                    // Get item count for each category
                    $category->item_count = Items::where('category', $category->name)
                        ->where('created_by', Auth::user()->creatorId())
                        ->count();
                    return $category;
                });
            
            return view('categories.index', compact('categories'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('item_category_add')) {
            return view('categories.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('item_category_add')) {
            // Only validate name and description
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string|max:1000',
            ], [
                'name.required' => __('Category name is required'),
                'name.unique' => __('This category name already exists'),
                'name.max' => __('Category name cannot exceed 255 characters'),
                'description.max' => __('Description cannot exceed 1000 characters'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            try {
                $category = new Category();
                $category->name = $request->name;
                $category->description = $request->description;
                // Status will be set automatically by migration default (true/1)
                $category->created_by = Auth::user()->creatorId();
                $category->save();

                DB::commit();

                return redirect()->route('categories.index')->with('success', __('Category created successfully.'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('Failed to create category. Please try again.'))
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
        if (\Auth::user()->can('item_category_view')) {
            $category = Category::find($id);
            
            if (!$category) {
                return redirect()->route('categories.index')->with('error', __('Category not found.'));
            }
            
            if ($category->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Get items for this category with pagination
            $items = Items::where('category', $category->name)
                ->where('created_by', Auth::user()->creatorId())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Get statistics
            $totalItems = Items::where('category', $category->name)
                ->where('created_by', Auth::user()->creatorId())
                ->count();
            
            return view('categories.show', compact('category', 'items', 'totalItems'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (\Auth::user()->can('item_category_edit')) {
            $category = Category::find($id);
            
            if (!$category) {
                return redirect()->route('categories.index')->with('error', __('Category not found.'));
            }
            
            if ($category->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('categories.edit', compact('category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('item_category_edit')) {
            $category = Category::find($id);
            
            if (!$category) {
                return redirect()->route('categories.index')->with('error', __('Category not found.'));
            }
            
            if ($category->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }

            // Only validate name and description
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'nullable|string|max:1000',
            ], [
                'name.required' => __('Category name is required'),
                'name.unique' => __('This category name already exists'),
                'name.max' => __('Category name cannot exceed 255 characters'),
                'description.max' => __('Description cannot exceed 1000 characters'),
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            try {
                $oldCategoryName = $category->name;
                
                $category->name = $request->name;
                $category->description = $request->description;
                // Don't update status automatically on edit
                $category->save();
                
                // Update items with new category name if name changed
                if ($oldCategoryName != $request->name) {
                    Items::where('category', $oldCategoryName)
                        ->where('created_by', Auth::user()->creatorId())
                        ->update(['category' => $request->name]);
                }

                DB::commit();

                return redirect()->route('categories.index')->with('success', __('Category updated successfully.'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', __('Failed to update category. Please try again.'))
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
        if (\Auth::user()->can('item_category_delete')) {
            $category = Category::find($id);
            
            if (!$category) {
                return redirect()->route('categories.index')->with('error', __('Category not found.'));
            }
            
            if ($category->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Check if category is being used in items
            $itemCount = Items::where('category', $category->name)
                ->where('created_by', Auth::user()->creatorId())
                ->count();
            
            if ($itemCount > 0) {
                return redirect()->route('categories.index')->with('error', 
                    __('Cannot delete category. It is being used in :count items.', ['count' => $itemCount]));
            }
            
            DB::beginTransaction();
            try {
                // Instead of deleting, set status to inactive (soft delete)
                $category->status = false;
                $category->save();
                
                DB::commit();
                
                return redirect()->route('categories.index')->with('success', __('Category deactivated successfully.'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('categories.index')->with('error', __('Failed to deactivate category. Please try again.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}