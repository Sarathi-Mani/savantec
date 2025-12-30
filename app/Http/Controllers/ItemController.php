<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\User;
use App\Models\Branch;
use App\Models\Tax;
use App\Models\Brand; 
use App\Models\Category; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->can('item_view')) {
            $items = Items::where('created_by', Auth::user()->creatorId())
                        ->with(['company', 'tax'])
                        ->orderBy('created_at', 'desc')
                        ->get();
            
            // Get companies from users table where type='company'
            $companies = User::where('type', 'company')
                ->where('created_by', Auth::user()->creatorId())
                ->get();
            
            return view('items.index', compact('items', 'companies'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('item_add')) {
            // Get companies from users table where type='company'
            $companies = User::where('type', 'company')
                ->where('created_by', Auth::user()->creatorId())
                ->get()
                ->pluck('name', 'id');
                
            
            // Get brands from Brand model (active only)
            $brands = Brand::where('created_by', Auth::user()->creatorId())
                        ->active()
                        ->orderBy('name', 'asc')
                        ->pluck('name', 'name')
                        ->toArray();
            
            // Get categories from Category model (active only)
            $categories = Category::where('created_by', Auth::user()->creatorId())
                            ->active()
                            ->orderBy('name', 'asc')
                            ->pluck('name', 'name')
                            ->toArray();
            
            // Get unique units from existing items
            $units = Items::where('created_by', Auth::user()->creatorId())
                       ->whereNotNull('unit')
                       ->distinct()
                       ->pluck('unit', 'unit')
                       ->toArray();
            
            // Add default units
            $defaultUnits = [
                'pc' => 'Piece (pc)',
                'kg' => 'Kilogram (kg)',
                'gm' => 'Gram (gm)',
                'ltr' => 'Liter (ltr)',
                'm' => 'Meter (m)',
                'cm' => 'Centimeter (cm)',
                'box' => 'Box',
                'pack' => 'Pack',
                'set' => 'Set',
                'pair' => 'Pair',
                'dozen' => 'Dozen',
            ];
            
            $units = array_merge($defaultUnits, $units);
            asort($units);
            
            // Get tax rates from database
            $taxes = Tax::where('created_by', Auth::user()->creatorId())->get();
           
            
            return view('items.create', compact('companies', 'brands', 'units', 'categories', 'taxes'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    if (\Auth::user()->can('item_add')) {
       
        // Debug: Log all request data
        \Log::info('Item Store Request Data:', $request->all());
        \Log::info('Tax Name:', ['tax_name' => $request->tax_name]);
        \Log::info('Tax Percentage:', ['tax_percentage' => $request->tax_percentage]);
        \Log::info('Tax ID:', ['tax_id' => $request->tax_id]);
        
        // Handle tax first - check if it's a custom tax
        $taxId = null;
        $taxName = $request->tax_name;
        $taxPercentage = $request->tax_percentage;
        
        // If custom tax was added
        if ($taxName && $taxPercentage) {
            // Ensure tax name has TAX@ prefix
            if (!str_starts_with($taxName, 'TAX@')) {
                $taxName = 'TAX@' . $taxPercentage . '%';
            }
            
            // Check if tax already exists for this company
            $existingTax = Tax::where('name', $taxName)
                           
                             ->where('created_by', Auth::user()->creatorId())
                             ->first();
            
            if ($existingTax) {
                // Use existing tax
                $taxId = $existingTax->id;
            } else {
                // Create new tax with TAX@ prefix
                $tax = Tax::create([
                    'name' => $taxName,
                    'rate' => $taxPercentage,
                  
                    'created_by' => Auth::user()->creatorId(),
                ]);
                
                $taxId = $tax->id;
            }
        } else {
            // Use existing tax_id if provided
            $taxId = $request->tax_id;
        }
        
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'hsn' => 'nullable|string|max:50',
                'barcode' => 'nullable|string|max:100|unique:items,barcode',
                'brand' => 'nullable|string|max:100',
                'other_brand' => 'nullable|string|max:100',
                'unit' => 'nullable|string|max:50',
                'company_id' => 'required|exists:users,id',
                'other_unit' => 'nullable|string|max:50',
                'alert_quantity' => 'nullable|integer|min:0',
                'category' => 'nullable|string|max:100',
                'other_category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount' => 'nullable|numeric|min:0',
                'price' => 'required|numeric|min:0',
             
                 'profit_margin' => 'nullable|numeric|min:0',
                'sku' => 'nullable|string|max:100|unique:items,sku',
                'seller_points' => 'nullable|integer|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'sales_price' => 'required|numeric|min:0',
                'opening_stock' => 'nullable|integer|min:0',
                'item_image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif,webp',
                'additional_image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif,webp',
                // Custom tax validation
                'tax_percentage' => 'required_with:tax_name|numeric|between:0,100',
                'tax_name' => 'required_with:tax_percentage|string|max:50',
            ],
            [
                'price.min' => 'Price must be greater than or equal to 0.',
                'purchase_price.min' => 'Purchase price must be greater than or equal to 0.',
                'sales_price.min' => 'Sales price must be greater than or equal to 0.',
                'sku.unique' => 'This SKU already exists. Please use a different SKU.',
                'barcode.unique' => 'This barcode already exists. Please use a different barcode.',
                'tax_percentage.required_with' => 'Tax percentage is required when tax name is provided.',
                'tax_name.required_with' => 'Tax name is required when tax percentage is provided.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle "other" fields
        $brand = $request->brand == 'other' ? $request->other_brand : $request->brand;
        $unit = $request->unit == 'other' ? $request->other_unit : $request->unit;
        $category = $request->category == 'other' ? $request->other_category : $request->category;

        // Create new brand if "other" is selected and brand doesn't exist
        if ($request->brand == 'other' && $request->other_brand) {
            $newBrand = $this->createBrand($request->other_brand);
            $brand = $newBrand->name;
        }

        // Create new category if "other" is selected and category doesn't exist
        if ($request->category == 'other' && $request->other_category) {
            $newCategory = $this->createCategory($request->other_category);
            $category = $newCategory->name;
        }

        // Calculate profit margin if not provided
        $profit_margin = $request->profit_margin;
        if (empty($profit_margin) && $request->purchase_price > 0) {
            $profit_margin = (($request->sales_price - $request->purchase_price) / $request->purchase_price) * 100;
        }

        $item = new Items();
        $item->name = $request->name;
        $item->item_group = "single";
        $item->hsn = $request->hsn;
        $item->barcode = $request->barcode;
        $item->brand = $brand;
        $item->unit = $unit;
        $item->alert_quantity = $request->alert_quantity ?? 0;
        $item->category = $category;
        $item->description = $request->description;
        $item->discount_type = $request->discount_type;
        $item->discount = $request->discount ?? 0;
        $item->price = $request->price;
        $item->company_id = $request->company_id; 
         
        $item->tax_id = $taxId; // Use the tax ID we found/created
        $item->profit_margin = $profit_margin ?? 0;
        $item->sku = $request->sku;
        $item->seller_points = $request->seller_points ?? 0;
        $item->purchase_price = $request->purchase_price;
        $item->sales_price = $request->sales_price;
        $item->opening_stock = $request->opening_stock ?? 0;
        $item->quantity = $request->opening_stock ?? 0;
        $item->created_by = Auth::user()->creatorId();

        // Handle main image upload
        if ($request->hasFile('item_image')) {
            $imageName = time() . '_item.' . $request->item_image->extension();
            $path = $request->item_image->storeAs('items', $imageName, 'public');
            $item->image = $path;
        }

        // Handle additional image upload
        if ($request->hasFile('additional_image')) {
            $additionalImageName = time() . '_additional.' . $request->additional_image->extension();
            $path = $request->additional_image->storeAs('items/additional', $additionalImageName, 'public');
            $item->additional_image = $path;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', __('Item created successfully.'));
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (\Auth::user()->can('item_view')) {
            $item = Items::with(['company', 'tax', 'creator'])->find($id);
            
            if (!$item) {
                return redirect()->route('items.index')->with('error', __('Item not found.'));
            }
            
            if ($item->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('items.show', compact('item'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (\Auth::user()->can('item_edit')) {
         
             $item = Items::with('tax')->find($id);
            
            if (!$item) {
                return redirect()->route('items.index')->with('error', __('Item not found.'));
            }
            
            if ($item->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Get companies from users table where type='company'
            $companies = User::where('type', 'company')
                ->where('created_by', Auth::user()->creatorId())
                ->get()
                ->pluck('name', 'id');
            
            // Get brands from Brand model (active only)
            $brands = Brand::where('created_by', Auth::user()->creatorId())
                        ->active()
                        ->orderBy('name', 'asc')
                        ->pluck('name', 'name')
                        ->toArray();
            
            // Get categories from Category model (active only)
            $categories = Category::where('created_by', Auth::user()->creatorId())
                            ->active()
                            ->orderBy('name', 'asc')
                            ->pluck('name', 'name')
                            ->toArray();
            
            // Get unique units from existing items
            $units = Items::where('created_by', Auth::user()->creatorId())
                       ->whereNotNull('unit')
                       ->distinct()
                       ->pluck('unit', 'unit')
                       ->toArray();
            
            // Add default units
            $defaultUnits = [
                'pc' => 'Piece (pc)',
                'kg' => 'Kilogram (kg)',
                'gm' => 'Gram (gm)',
                'ltr' => 'Liter (ltr)',
                'm' => 'Meter (m)',
                'cm' => 'Centimeter (cm)',
                'box' => 'Box',
                'pack' => 'Pack',
                'set' => 'Set',
                'pair' => 'Pair',
                'dozen' => 'Dozen',
            ];
            
            $units = array_merge($defaultUnits, $units);
            asort($units);
            
            $taxes = Tax::where('created_by', Auth::user()->creatorId())->get();
        
            
            return view('items.edit', compact('item', 'companies', 'brands', 'units', 'categories', 'taxes'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
   /**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    if (\Auth::user()->can('item_edit')) {
        $item = Items::find($id);
        
        if (!$item) {
            return redirect()->route('items.index')->with('error', __('Item not found.'));
        }
        
        if ($item->created_by != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        // Handle tax first - check if it's a custom tax
        $taxId = null;
        $taxName = $request->tax_name;
        $taxPercentage = $request->tax_percentage;
        
        // If custom tax was added
        if ($taxName && $taxPercentage) {
            // Ensure tax name has TAX@ prefix
            if (!str_starts_with($taxName, 'TAX@')) {
                $taxName = 'TAX@' . $taxPercentage . '%';
            }
            
            // Check if tax already exists for this company
            $existingTax = Tax::where('name', $taxName)
                            ->where('created_by', Auth::user()->creatorId())
                            ->first();
            
            if ($existingTax) {
                // Use existing tax
                $taxId = $existingTax->id;
            } else {
                // Create new tax with TAX@ prefix
                $tax = Tax::create([
                    'name' => $taxName,
                    'rate' => $taxPercentage,
                    'created_by' => Auth::user()->creatorId(),
                ]);
                
                $taxId = $tax->id;
            }
        } else {
            // Use existing tax_id if provided
            $taxId = $request->tax_id;
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'hsn' => 'nullable|string|max:50',
                'barcode' => 'nullable|string|max:100|unique:items,barcode,' . $id,
                'brand' => 'nullable|string|max:100',
                'other_brand' => 'nullable|string|max:100',
                'unit' => 'nullable|string|max:50',
                'other_unit' => 'nullable|string|max:50',
                'alert_quantity' => 'nullable|integer|min:0',
                'category' => 'nullable|string|max:100',
                'other_category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount' => 'nullable|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'company_id' => 'required|exists:users,id',
                'profit_margin' => 'nullable|numeric|min:0',
                'sku' => 'nullable|string|max:100|unique:items,sku,' . $id,
                'seller_points' => 'nullable|integer|min:0',
                'purchase_price' => 'required|numeric|min:0',
                'sales_price' => 'required|numeric|min:0',
                'opening_stock' => 'nullable|integer|min:0',
                'item_image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif,webp',
                'additional_image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif,webp',
                // Custom tax validation
                'tax_percentage' => 'required_with:tax_name|numeric|between:0,100',
                'tax_name' => 'required_with:tax_percentage|string|max:50',
            ],
            [
                'price.min' => 'Price must be greater than or equal to 0.',
                'purchase_price.min' => 'Purchase price must be greater than or equal to 0.',
                'sales_price.min' => 'Sales price must be greater than or equal to 0.',
                'sku.unique' => 'This SKU already exists. Please use a different SKU.',
                'barcode.unique' => 'This barcode already exists. Please use a different barcode.',
                'tax_percentage.required_with' => 'Tax percentage is required when tax name is provided.',
                'tax_name.required_with' => 'Tax name is required when tax percentage is provided.',
                'company_id.required' => 'Please select a company.',
                'company_id.exists' => 'The selected company does not exist.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle "other" fields
        $brand = $request->brand == 'other' ? $request->other_brand : $request->brand;
        $unit = $request->unit == 'other' ? $request->other_unit : $request->unit;
        $category = $request->category == 'other' ? $request->other_category : $request->category;

        // Create new brand if "other" is selected and brand doesn't exist
        if ($request->brand == 'other' && $request->other_brand) {
            $newBrand = $this->createBrand($request->other_brand);
            $brand = $newBrand->name;
        }

        // Create new category if "other" is selected and category doesn't exist
        if ($request->category == 'other' && $request->other_category) {
            $newCategory = $this->createCategory($request->other_category);
            $category = $newCategory->name;
        }

        // Calculate profit margin if not provided
        $profit_margin = $request->profit_margin;
        if (empty($profit_margin) && $request->purchase_price > 0) {
            $profit_margin = (($request->sales_price - $request->purchase_price) / $request->purchase_price) * 100;
        }

        $item->name = $request->name;
        $item->item_group = "single";
        $item->hsn = $request->hsn;
        $item->barcode = $request->barcode;
        $item->brand = $brand;
        $item->unit = $unit;
        $item->company_id = $request->company_id; // Make sure to update company_id
        $item->alert_quantity = $request->alert_quantity ?? 0;
        $item->category = $category;
        $item->description = $request->description;
        $item->discount_type = $request->discount_type;
        $item->discount = $request->discount ?? 0;
        $item->price = $request->price;
        $item->tax_id = $taxId; // Use the tax ID we found/created
        $item->profit_margin = $profit_margin ?? 0;
        $item->sku = $request->sku;
        $item->seller_points = $request->seller_points ?? 0;
        $item->purchase_price = $request->purchase_price;
        $item->sales_price = $request->sales_price;
        
        // Update stock if opening stock changed
        if ($request->opening_stock != $item->opening_stock) {
            $stockDifference = $request->opening_stock - $item->opening_stock;
            $item->quantity += $stockDifference;
            $item->opening_stock = $request->opening_stock ?? 0;
        }

        // Handle main image upload
        if ($request->hasFile('item_image')) {
            // Delete old image if exists
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            
            $imageName = time() . '_item.' . $request->item_image->extension();
            $path = $request->item_image->storeAs('items', $imageName, 'public');
            $item->image = $path;
        }

        // Handle additional image upload
        if ($request->hasFile('additional_image')) {
            // Delete old additional image if exists
            if ($item->additional_image && Storage::disk('public')->exists($item->additional_image)) {
                Storage::disk('public')->delete($item->additional_image);
            }
            
            $additionalImageName = time() . '_additional.' . $request->additional_image->extension();
            $path = $request->additional_image->storeAs('items/additional', $additionalImageName, 'public');
            $item->additional_image = $path;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', __('Item updated successfully.'));
    } else {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('item_delete')) {
            $item = Items::find($id);
            
            if (!$item) {
                return redirect()->route('items.index')->with('error', __('Item not found.'));
            }
            
            if ($item->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Delete images if they exist
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            
            if ($item->additional_image && Storage::disk('public')->exists($item->additional_image)) {
                Storage::disk('public')->delete($item->additional_image);
            }
            
            $item->delete();
            
            return redirect()->route('items.index')->with('success', __('Item deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Get items for select2 dropdown (for AJAX requests)
     */
    public function getItems(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $items = Items::where('created_by', Auth::user()->creatorId())
                ->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('sku', 'LIKE', "%{$search}%")
                          ->orWhere('barcode', 'LIKE', "%{$search}%");
                })
                ->select('id', 'name', 'sku', 'price', 'sales_price', 'quantity')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->name . ' (' . $item->sku . ') - Stock: ' . $item->quantity,
                        'price' => $item->price,
                        'sales_price' => $item->sales_price,
                        'quantity' => $item->quantity
                    ];
                });
                
            return response()->json($items);
        }
    }

    /**
     * Get item details by ID (for AJAX requests)
     */
    public function getItemDetails($id)
    {
        $item = Items::where('created_by', Auth::user()->creatorId())
                   ->find($id);
        
        if ($item) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'sku' => $item->sku,
                    'price' => $item->price,
                    'sales_price' => $item->sales_price,
                    'purchase_price' => $item->purchase_price,
                    'quantity' => $item->quantity,
                    'tax_id' => $item->tax_id,
                  
                    'discount' => $item->discount,
                    'discount_type' => $item->discount_type,
                ]
            ]);
        }
        
        return response()->json(['success' => false]);
    }

    /**
     * Create a new brand from "other" field
     */
    private function createBrand($brandName)
    {
        // Check if brand already exists
        $existingBrand = Brand::where('created_by', Auth::user()->creatorId())
                            ->where('name', $brandName)
                            ->first();
        
        if ($existingBrand) {
            return $existingBrand;
        }
        
        // Create new brand
        $brand = new Brand();
        $brand->name = $brandName;
        $brand->status = true;
        $brand->created_by = Auth::user()->creatorId();
        $brand->save();
        
        return $brand;
    }

    /**
     * Create a new category from "other" field
     */
    private function createCategory($categoryName)
    {
        // Check if category already exists
        $existingCategory = Category::where('created_by', Auth::user()->creatorId())
                                  ->where('name', $categoryName)
                                  ->first();
        
        if ($existingCategory) {
            return $existingCategory;
        }
        
        // Create new category
        $category = new Category();
        $category->name = $categoryName;
        $category->status = true;
        $category->created_by = Auth::user()->creatorId();
        $category->save();
        
        return $category;
    }

    /**
     * Export items to CSV
     */
    public function export()
    {
        if (\Auth::user()->can('item_export')) {
            $items = Items::where('created_by', Auth::user()->creatorId())
                        ->with(['company', 'tax'])
                        ->get();
            
            $fileName = 'items_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];
            
            $callback = function() use ($items) {
                $file = fopen('php://output', 'w');
                
                // Add CSV headers
                fputcsv($file, [
                    'ID',
                    'Name',
                    'SKU',
                    'Barcode',
                    'HSN',
                    'Brand',
                    'Category',
                    'Unit',
                    'Price',
                    'Purchase Price',
                    'Sales Price',
                    'MRP',
                    'Profit Margin %',
                    'Tax Type',
                    'Tax',
                    'Discount Type',
                    'Discount',
                    'Alert Quantity',
                    'Opening Stock',
                    'Current Stock',
                    'Seller Points',
                    'Company',
                    'Description',
                    'Created At'
                ]);
                
                // Add data rows
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->id,
                        $item->name,
                        $item->sku,
                        $item->barcode,
                        $item->hsn,
                        $item->brand,
                        $item->category,
                        $item->unit,
                        $item->price,
                        $item->purchase_price,
                        $item->sales_price,
                        $item->mrp,
                        $item->profit_margin,
                      
                        $item->tax ? $item->tax->name . ' (' . $item->tax->rate . '%)' : 'N/A',
                        $item->discount_type,
                        $item->discount,
                        $item->alert_quantity,
                        $item->opening_stock,
                        $item->quantity,
                        $item->seller_points,
                        $item->company ? $item->company->name : 'N/A',
                        $item->description,
                        $item->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}