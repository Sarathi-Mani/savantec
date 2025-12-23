<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the form for creating a new resource.
     */
  // In QuotationController.php, update the create method:


  public function exportCSV(Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $fileName = 'quotations_' . date('Y-m-d') . '.csv';
            
            $headers = array(
                "Content-type"        => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $callback = function() {
                $handle = fopen('php://output', 'w');
                
                // Add UTF-8 BOM to handle special characters
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Headers - remove currency symbol
                fputcsv($handle, [
                    'SL No',
                    'Quotation Date',
                    'Expiry Date', 
                    'Quotation Code',
                    'Reference No',
                    'Customer',
                    'Salesman',
                    'Total Amount',
                    'Status',
                    'Created At'
                ]);

                // Get data
                $quotations = Quotation::where('company_id', Auth::user()->creatorId())
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $counter = 1;
                
                foreach ($quotations as $quotation) {
                    // Get salesman name
                    $salesman = \App\Models\User::find($quotation->salesman_id);
                    
                    // Format date
                    $quotationDate = $quotation->quotation_date ? 
                        \Carbon\Carbon::parse($quotation->quotation_date)->format('d-m-Y') : '';
                    
                    $expireDate = $quotation->expire_date ? 
                        \Carbon\Carbon::parse($quotation->expire_date)->format('d-m-Y') : '';
                    
                    // Format amount WITHOUT currency symbol - just the number
                    $totalAmount = number_format($quotation->grand_total, 2);
                    
                    fputcsv($handle, [
                        $counter++,
                        $quotationDate,
                        $expireDate,
                        $quotation->quotation_code,
                        $quotation->reference_no ?? '',
                        $quotation->customer_name,
                        $salesman->name ?? 'N/A',
                        $totalAmount, // Number only, no currency symbol
                        ucfirst($quotation->status),
                        $quotation->created_at->format('d-m-Y')
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    

public function create()
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        // Check if coming from enquiry conversion
        $enquiryData = session('converted_enquiry');
        $selectedCustomerId = null; // Initialize here
        
        // Get customers (companies) - assuming Customer model is your companies
        $customers = Customer::where('created_by', Auth::user()->creatorId())
                             ->where('is_active', '1')
                             ->orderBy('name')
                             ->get();
        
        // If coming from enquiry, pre-select the customer
        if ($enquiryData && isset($enquiryData['customer_id'])) {
            $selectedCustomerId = $enquiryData['customer_id'];
        }
        
        $salesmen = User::where('type', 'sales enginner')
                        ->where('is_active', 1)
                        ->pluck('name', 'id');
        
        if($salesmen->isEmpty()) {
            $salesmen = User::where('type', '!=', 'company')
                            ->where('is_active', 1)
                            ->pluck('name', 'id');
        }
        
        // Get items from Items module - assuming you have an Item model
        // Replace 'Item' with your actual model name
        $itemsModel = '\App\Models\Items'; // Change this to your actual Item model
        
        if (class_exists($itemsModel)) {
            $items = $itemsModel::where('created_by', Auth::user()->creatorId())
                                ->where('deleted_at', NULL)
                                ->orderBy('name')
                                ->pluck('name', 'id');
        }
        
        // Generate quotation code - FIXED REGEX PATTERN
        $lastQuotation = Quotation::orderBy('id', 'desc')->first();
        $quotationCode = 'SAPL/' . '0001';
        
        if ($lastQuotation && !empty($lastQuotation->quotation_code)) {
            // Fixed regex pattern - escape forward slash properly
            if (preg_match('/SAPL\/\d{8}-(\d{4})/', $lastQuotation->quotation_code, $matches)) {
                $lastNumber = (int)$matches[1];
                $nextNumber = $lastNumber + 1;
                $quotationCode = 'SAPL/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else {
                // If pattern doesn't match, generate sequential number
                $lastNumber = (int) filter_var($lastQuotation->quotation_code, FILTER_SANITIZE_NUMBER_INT);
                $nextNumber = $lastNumber + 1;
                $quotationCode = 'SAPL/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        }
        
        return view('quotation.create', compact(
            'customers',
            'salesmen',
            'items',
            'quotationCode',
            'enquiryData',
            'selectedCustomerId' // Changed to selectedCustomerId
        ));
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}




    public function index()
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        // Get quotations for the current company with pagination
        $quotations = Quotation::where('company_id', Auth::user()->creatorId())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 items per page
        
        return view('quotation.index', compact('quotations'));
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}


// Add these methods to your QuotationController

/**
 * Generate PDF for quotation
 */
public function pdf($id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        // For now, redirect to print page
        // TODO: Implement actual PDF generation
        return redirect()->route('quotation.print', $id);
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}

/**
 * Get customer details via AJAX
 */
public function getCustomerDetails(Request $request)
{
    $customerId = $request->customer_id;
    $customer = Customer::find($customerId);
    
    if (!$customer) {
        return response()->json(['error' => 'Customer not found'], 404);
    }
    
    return response()->json([
        'name' => $customer->name,
        'email' => $customer->email,
        'mobile' => $customer->mobile,
        'shipping_state' => $customer->shipping_state,
        'billing_address' => $customer->billing_address,
        'shipping_address' => $customer->shipping_address
    ]);
}

/**
 * Get contact persons for customer
 */
public function getContactPersons(Request $request)
{
    // If you have a separate contact_persons table, query it here
    // For now, return empty or use customer details
    $customerId = $request->customer_id;
    $customer = Customer::find($customerId);
    
    if (!$customer) {
        return response()->json(['error' => 'Customer not found'], 404);
    }
    
    return response()->json([
        'contact_person' => $customer->contact_person ?? $customer->name
    ]);
}

/**
 * Get item price via AJAX
 */
public function getItemPrice(Request $request)
{
    $itemId = $request->item_id;
    
    // Replace with your actual item model query
    // $item = Item::find($itemId);
    
    // For now, return dummy data
    return response()->json([
        'unit_price' => 1000.00,
        'tax_percentage' => 18,
        'description' => 'Item description'
    ]);
}

/**
 * Datatable method for AJAX loading
 */
public function datatable(Request $request)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotations = Quotation::where('company_id', Auth::user()->creatorId())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return datatables()->of($quotations)
            ->addColumn('actions', function($quotation) {
                $actions = '';
                
                if(\Auth::user()->can('quotation_view')) {
                    $actions .= '<a href="'.route('quotation.show', $quotation->id).'" class="btn btn-sm btn-outline-primary" title="View"><i class="ti ti-eye"></i></a> ';
                }
                
                if(\Auth::user()->can('quotation_edit')) {
                    $actions .= '<a href="'.route('quotation.edit', $quotation->id).'" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="ti ti-pencil"></i></a> ';
                }
                
                if(\Auth::user()->can('print quotation')) {
                    $actions .= '<a href="'.route('quotation.print', $quotation->id).'" target="_blank" class="btn btn-sm btn-outline-info" title="Print"><i class="ti ti-printer"></i></a> ';
                }
                
                if(\Auth::user()->can('convert quotation')) {
                    $actions .= '<a href="'.route('quotation.convert-to-invoice', $quotation->id).'" class="btn btn-sm btn-outline-success" title="Convert to Invoice" onclick="return confirm(\'Are you sure?\')"><i class="ti ti-file-invoice"></i></a> ';
                }
                
                if(\Auth::user()->can('quotation_delete')) {
                    $actions .= '<form action="'.route('quotation.destroy', $quotation->id).'" method="POST" class="d-inline">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="ti ti-trash"></i></button>
                    </form>';
                }
                
                return $actions;
            })
            ->addColumn('salesman_name', function($quotation) {
                $salesman = User::find($quotation->salesman_id);
                return $salesman->name ?? 'N/A';
            })
            ->addColumn('formatted_total', function($quotation) {
                return number_format($quotation->grand_total, 2);
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    
    return response()->json(['error' => 'Permission denied'], 403);
}


    /**
     * Store a newly created resource in storage.
     */
/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        \Log::info('=== QUOTATION STORE STARTED ===');
        \Log::info('Request Data:', $request->all());
        
        // Simplified validation - remove exists:items,id if you don't have items table
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'contact_person' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'status' => 'required|string|in:open,closed,po_converted,lost',
            'salesman_id' => 'required|exists:users,id',
            'quotation_code' => 'required|string|unique:quotations,quotation_code',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|string|max:255', // Changed from exists:items,id
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation Errors:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $customer = Customer::findOrFail($request->customer_id);
            
            // ⚠️ FIXED: Assign date values from request - NOT null!
            $quotationDate = $request->quotation_date; // Directly assign
            $expireDate = $request->expire_date; // Can be null if empty
            $referenceDate = $request->reference_date; // Can be null if empty
            
            // Determine GST type based on customer shipping state
            $supplierState = 'Tamil Nadu';
            $customerState = $customer->shipping_state;
            
            $gstType = $this->determineGstType($customerState, $supplierState);
            
            // Calculate totals from form data
            $subtotal = $request->subtotal ?? 0;
            $totalCgst = $request->cgst ?? 0;
            $totalSgst = $request->sgst ?? 0;
            $totalIgst = $request->igst ?? 0;
            $totalDiscount = $request->total_discount ?? 0;
            $roundOff = $request->round_off ?? 0;
            $grandTotal = $request->grand_total ?? 0;
            $totalItems = count($request->items);
            $totalQuantity = array_sum(array_column($request->items, 'quantity'));
            
            // Create quotation with ALL required fields
            $quotation = new Quotation();
            $quotation->quotation_code = $request->quotation_code;
            $quotation->customer_id = $request->customer_id;
            $quotation->customer_name = $customer->name;
            $quotation->customer_email = $customer->email;
            $quotation->customer_mobile = $customer->mobile;
            $quotation->contact_person = $request->contact_person;
            $quotation->quotation_date = $quotationDate; // Use assigned date
            $quotation->expire_date = $expireDate;
            $quotation->status = $request->status;
            $quotation->salesman_id = $request->salesman_id;
            $quotation->reference = $request->reference;
            $quotation->reference_no = $request->reference_no;
            $quotation->reference_date = $referenceDate;
            $quotation->payment_terms = $request->payment_terms;
            $quotation->gst_type = $gstType;
            $quotation->subtotal = $subtotal;
            $quotation->other_charges = $request->other_charges_amount ?? 0;
            $quotation->total_discount = $totalDiscount;
            $quotation->cgst = $totalCgst;
            $quotation->sgst = $totalSgst;
            $quotation->igst = $totalIgst;
            $quotation->round_off = $roundOff;
            $quotation->grand_total = $grandTotal;
            $quotation->total_items = $totalItems;
            $quotation->total_quantity = $totalQuantity;
            $quotation->description = $request->description;
            $quotation->customer_message = $request->customer_message;
            $quotation->send_email = $request->has('send_email') ? 1 : 0;
            $quotation->created_by = Auth::id();
            $quotation->company_id = Auth::user()->creatorId();
            
            // Save and check for errors
            \Log::info('Saving quotation with data:', $quotation->toArray());
            
            if (!$quotation->save()) {
                throw new \Exception('Failed to save quotation');
            }
            
            \Log::info('Quotation saved with ID: ' . $quotation->id);
            
            // Save items
            foreach($request->items as $index => $itemData) {
                if(!empty($itemData['item_id'])) {
                    \Log::info("Saving item {$index}: ", $itemData);
                    
                    $quotationItem = new QuotationItem();
                    $quotationItem->quotation_id = $quotation->id;
                    $quotationItem->item_name = $itemData['item_id']; // This is the text, not ID
                    $quotationItem->description = $itemData['description'] ?? '';
                    $quotationItem->quantity = $itemData['quantity'] ?? 0;
                    $quotationItem->unit_price = $itemData['unit_price'] ?? 0;
                    $quotationItem->discount = $itemData['discount'] ?? 0;
                    $quotationItem->discount_type = 'percent'; // Default
                    
                    // Calculate tax rates based on item tax percentage
                    $taxPercentage = $itemData['tax_percentage'] ?? 18;
                    if($gstType === 'cgst_sgst') {
                        $quotationItem->cgst_rate = $taxPercentage / 2;
                        $quotationItem->sgst_rate = $taxPercentage / 2;
                        $quotationItem->igst_rate = 0;
                    } else {
                        $quotationItem->cgst_rate = 0;
                        $quotationItem->sgst_rate = 0;
                        $quotationItem->igst_rate = $taxPercentage;
                    }
                    
                    // Convert total_amount from formatted string to number
                    $totalAmount = $itemData['total_amount'] ?? '0.00';
                    if (is_string($totalAmount)) {
                        $totalAmount = (float) preg_replace('/[^0-9.-]+/', '', $totalAmount);
                    }
                    $quotationItem->total_amount = $totalAmount;
                    
                    if (!$quotationItem->save()) {
                        \Log::error('Failed to save quotation item:', $itemData);
                        throw new \Exception('Failed to save quotation item: ' . $itemData['item_id']);
                    }
                    
                    \Log::info("Item {$index} saved successfully");
                }
            }
            
            DB::commit();
            \Log::info('=== QUOTATION STORE COMPLETED SUCCESSFULLY ===');
            
            return redirect()->route('quotation.index')->with('success', __('Quotation created successfully.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error for debugging
            \Log::error('Quotation Creation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', __('Error creating quotation: ') . $e->getMessage())
                ->withInput();
        }
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $quotation = Quotation::with('items')->findOrFail($id);
            
            // Check if quotation belongs to current company
            if($quotation->company_id != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('quotation.show', compact('quotation'));
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }

   /**
 * Show the form for editing the specified resource.
 */
public function edit($id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        $customers = Customer::where('created_by', Auth::user()->creatorId())
                             ->where('is_active', '1')
                             ->orderBy('name')
                             ->get();
        
        $salesmen = User::where('type', 'sales enginner')
                        ->where('is_active', 1)
                        ->pluck('name', 'id');
        
        if($salesmen->isEmpty()) {
            $salesmen = User::where('type', '!=', 'company')
                            ->where('is_active', 1)
                            ->pluck('name', 'id');
        }
        
        // Get items from Items module - using the same logic as create method
        $itemsModel = '\App\Models\Items'; // Change this to your actual Item model
        
        if (class_exists($itemsModel)) {
            $items = $itemsModel::where('created_by', Auth::user()->creatorId())
                                ->where('deleted_at', NULL)
                                ->orderBy('name')
                                ->pluck('name', 'id');
        } else {
            // Fallback dummy items if model doesn't exist
            $items = [
                1 => 'Office Chair',
                2 => 'Office Desk', 
                3 => 'Computer Monitor',
                4 => 'Keyboard & Mouse',
                5 => 'Conference Table'
            ];
        }
        
        return view('quotation.edit', compact('quotation', 'customers', 'salesmen', 'items'));
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}
 /**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        \Log::info('=== QUOTATION UPDATE STARTED ===');
        \Log::info('Request Data:', $request->all());
        
        // Similar validation as store method
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'contact_person' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'status' => 'required|string|in:open,closed,po_converted,lost',
            'salesman_id' => 'required|exists:users,id',
            'quotation_code' => 'required|string|unique:quotations,quotation_code,' . $id,
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation Errors:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $customer = Customer::findOrFail($request->customer_id);
            
            // Determine GST type based on customer shipping state
            $supplierState = 'Tamil Nadu';
            $customerState = $customer->shipping_state;
            $gstType = $this->determineGstType($customerState, $supplierState);
            
            // Calculate totals from form data
            $subtotal = $request->subtotal ?? 0;
            $totalCgst = $request->cgst ?? 0;
            $totalSgst = $request->sgst ?? 0;
            $totalIgst = $request->igst ?? 0;
            $totalDiscount = $request->total_discount ?? 0;
            $grandTotal = $request->grand_total ?? 0;
            $totalItems = count($request->items);
            $totalQuantity = array_sum(array_column($request->items, 'quantity'));
            
            // Update quotation
            $quotation->quotation_code = $request->quotation_code;
            $quotation->customer_id = $request->customer_id;
            $quotation->customer_name = $customer->name;
            $quotation->customer_email = $customer->email;
            $quotation->customer_mobile = $customer->mobile;
            $quotation->contact_person = $request->contact_person;
            $quotation->quotation_date = $request->quotation_date;
            $quotation->expire_date = $request->expire_date;
            $quotation->status = $request->status;
            $quotation->salesman_id = $request->salesman_id;
            $quotation->reference = $request->reference;
            $quotation->reference_no = $request->reference_no;
            $quotation->reference_date = $request->reference_date;
            $quotation->payment_terms = $request->payment_terms;
            $quotation->gst_type = $gstType;
            $quotation->tax_type = $request->tax_type;
            $quotation->tax_regime = $request->tax_regime;
            $quotation->subtotal = $subtotal;
            $quotation->total_discount = $totalDiscount;
            $quotation->cgst = $totalCgst;
            $quotation->sgst = $totalSgst;
            $quotation->igst = $totalIgst;
            $quotation->grand_total = $grandTotal;
            $quotation->total_items = $totalItems;
            $quotation->total_quantity = $totalQuantity;
            $quotation->description = $request->description;
            $quotation->updated_by = Auth::id();
            
            \Log::info('Updating quotation with data:', $quotation->toArray());
            
            if (!$quotation->save()) {
                throw new \Exception('Failed to update quotation');
            }
            
            \Log::info('Quotation updated with ID: ' . $quotation->id);
            
            // Delete existing items and save new ones
            QuotationItem::where('quotation_id', $quotation->id)->delete();
            
            // Save items
            foreach($request->items as $index => $itemData) {
                if(!empty($itemData['item_id'])) {
                    \Log::info("Saving item {$index}: ", $itemData);
                    
                    $quotationItem = new QuotationItem();
                    $quotationItem->quotation_id = $quotation->id;
                    $quotationItem->item_name = $itemData['item_id'];
                    $quotationItem->description = $itemData['description'] ?? '';
                    $quotationItem->quantity = $itemData['quantity'] ?? 0;
                    $quotationItem->unit_price = $itemData['unit_price'] ?? 0;
                    $quotationItem->discount = $itemData['discount'] ?? 0;
                    $quotationItem->discount_type = 'percent';
                    
                    // Calculate tax rates based on item tax percentage
                    $taxPercentage = $itemData['tax_percentage'] ?? 18;
                    if($gstType === 'cgst_sgst') {
                        $quotationItem->cgst_rate = $taxPercentage / 2;
                        $quotationItem->sgst_rate = $taxPercentage / 2;
                        $quotationItem->igst_rate = 0;
                    } else {
                        $quotationItem->cgst_rate = 0;
                        $quotationItem->sgst_rate = 0;
                        $quotationItem->igst_rate = $taxPercentage;
                    }
                    
                    // Convert total_amount from formatted string to number
                    $totalAmount = $itemData['total_amount'] ?? '0.00';
                    if (is_string($totalAmount)) {
                        $totalAmount = (float) preg_replace('/[^0-9.-]+/', '', $totalAmount);
                    }
                    $quotationItem->total_amount = $totalAmount;
                    
                    if (!$quotationItem->save()) {
                        \Log::error('Failed to save quotation item:', $itemData);
                        throw new \Exception('Failed to save quotation item: ' . $itemData['item_id']);
                    }
                    
                    \Log::info("Item {$index} saved successfully");
                }
            }
            
            DB::commit();
            \Log::info('=== QUOTATION UPDATE COMPLETED SUCCESSFULLY ===');
            
            return redirect()->route('quotation.index')->with('success', __('Quotation updated successfully.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error for debugging
            \Log::error('Quotation Update Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', __('Error updating quotation: ') . $e->getMessage())
                ->withInput();
        }
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $quotation = Quotation::findOrFail($id);
            
            // Check if quotation belongs to current company
            if($quotation->company_id != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Delete items first
            QuotationItem::where('quotation_id', $id)->delete();
            
            // Delete quotation
            $quotation->delete();
            
            return redirect()->route('quotation.index')->with('success', __('Quotation deleted successfully.'));
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function print($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $quotation = Quotation::with('items')->findOrFail($id);
            
            // Check if quotation belongs to current company
            if($quotation->company_id != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('quotation.print', compact('quotation'));
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }
    
    /**
     * Convert quotation to invoice
     */
    public function convertToInvoice($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $quotation = Quotation::with('items')->findOrFail($id);
            
            // Check if quotation belongs to current company
            if($quotation->company_id != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            // Check if quotation is already converted
            if($quotation->status == 'po_converted') {
                return redirect()->back()->with('error', __('This quotation has already been converted to PO.'));
            }
            
            // Update quotation status
            $quotation->status = 'po_converted';
            $quotation->save();
            
            return redirect()->route('invoice.create')->with('success', __('Quotation converted to invoice successfully.'))
                                                      ->with('quotation_id', $quotation->id);
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }
    
    /**
     * Convert quotation to delivery challan
     */
    public function convertToDC($id)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            $quotation = Quotation::with('items')->findOrFail($id);
            
            // Check if quotation belongs to current company
            if($quotation->company_id != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return redirect()->route('delivery-challan.create')->with('success', __('Quotation ready to convert to Delivery Challan.'))
                                                              ->with('quotation_id', $quotation->id);
        }
        
        return redirect()->back()->with('error', __('Permission denied.'));
    }
    

    private function determineGstType($customerState, $supplierState = 'Tamil Nadu')
    {
        if (!$customerState) {
            return 'igst';
        }
        
        // Clean and normalize state names
        $cleanSupplierState = strtolower(trim($supplierState));
        $cleanCustomerState = strtolower(trim($customerState));
        
        // Handle "Tamilnadu" vs "Tamil Nadu" comparison
        $isSameState = false;
        if ($cleanCustomerState) {
            if ($cleanCustomerState === $cleanSupplierState) {
                $isSameState = true;
            } elseif ($cleanCustomerState === 'tamilnadu' && $cleanSupplierState === 'tamil nadu') {
                $isSameState = true;
            } elseif ($cleanCustomerState === 'tamil nadu' && $cleanSupplierState === 'tamilnadu') {
                $isSameState = true;
            }
        }
        
        return $isSameState ? 'cgst_sgst' : 'igst';
    }
    
    /**
     * Get GST type via AJAX
     */
   

   public function getGstType(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        
        $supplierState = 'Tamil Nadu';
        $customerState = $customer->shipping_state;
        
        $gstType = $this->determineGstType($customerState, $supplierState);
        
        if ($gstType === 'cgst_sgst') {
            $message = 'Customer is in Tamil Nadu (same state). CGST + SGST will be applied.';
        } else {
            $message = $customerState ? 
                'Customer is in different state. IGST will be applied.' : 
                'Customer shipping state not specified. IGST will be applied.';
        }
        
        return response()->json([
            'gst_type' => $gstType,
            'customer_state' => $customerState,
            'supplier_state' => $supplierState,
            'message' => $message
        ]);
    }
}