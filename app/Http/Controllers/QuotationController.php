<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\User;
use App\Models\Items;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log; 
use PDF;

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
        
        $items = [];
        $itemDetails = [];
        
        if (class_exists($itemsModel)) {
            $itemRecords = $itemsModel::where('created_by', Auth::user()->creatorId())
                                ->where('deleted_at', NULL)
                                ->orderBy('name')
                                ->get();
            
            // Prepare items array for dropdown
            foreach ($itemRecords as $item) {
                $items[$item->id] = $item->name;
                $itemDetails[$item->id] = [
                    'hsn' => $item->hsn?? '',
                    'sku' => $item->sku ?? '',
                     'discount' => $item->discount ?? 0,
                    'description' => $item->description ?? '',
                    'discount_type' => $item->discount_type ?? 'percentage',
                    'price' => $item->sales_price ?? 0,
                    'tax_rate' => $item->tax_rate ?? 18
                ];
            }
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
            'selectedCustomerId',
            'itemDetails' // Add this line
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
/**
 * Generate PDF for quotation
 */
public function pdf($id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::with(['items', 'salesman', 'customer'])->findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        // Format amount in words
        $amountInWords = $this->numberToWords($quotation->grand_total);
        
        // Pass company info from authenticated user
        $company_info = [
            'company_name' => \Auth::user()->company_name ?? 'Company Name',
            'company_address' => \Auth::user()->company_address ?? 'Company Address',
            'company_city' => \Auth::user()->company_city ?? 'City',
            'company_state' => \Auth::user()->company_state ?? 'State',
            'company_zip_code' => \Auth::user()->company_zip_code ?? 'ZIP Code',
            'company_email' => \Auth::user()->company_email ?? 'Email',
            'company_phone' => \Auth::user()->company_phone ?? 'Phone',
            'company_gstin' => \Auth::user()->company_gstin ?? 'GST Number',
            'company_logo' => \Auth::user()->company_logo ?? null,
        ];
        
        // Create PDF
        $data = compact('quotation', 'amountInWords') + $company_info;
        
        $pdf = PDF::loadView('quotation.print', $data);
        
        // Set PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'isPhpEnabled' => true,
        ]);
        
        // Clean filename - remove invalid characters
        $filename = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $quotation->quotation_code);
        $filename = 'quotation-' . $filename . '.pdf';
        
        // Check action parameter
        $action = request()->get('action', 'download');
        
        if ($action === 'view') {
            // Show in browser
            return $pdf->stream($filename);
        } else {
            // Download directly
            return $pdf->download($filename);
        }
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
/**
 * Get item price via AJAX
 */
public function getItemPrice(Request $request)
{
    try {
        $itemId = $request->item_id;
        $item = Items::find($itemId);
        
        if ($item) {
            return response()->json([
                'success' => true,
                'price' => $item->sales_price ?? 0,
                'tax_percentage' => $item->tax_rate ?? 18,
                'description' => $item->description ?? ''
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in getItemPrice: ' . $e->getMessage());
        return response()->json(['success' => false]);
    }
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
/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        \Log::info('=== QUOTATION STORE STARTED ===');
        \Log::info('User ID: ' . Auth::id());
        \Log::info('Creator ID: ' . Auth::user()->creatorId());
        \Log::info('Request Data:', $request->all());
        
        // DEBUG: Log the form data structure
        \Log::info('Items array structure:');
        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                \Log::info("Item {$index}: " . print_r($item, true));
            }
        } else {
            \Log::error('NO ITEMS FOUND IN REQUEST!');
        }
        
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'contact_person' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'status' => 'required|string|in:open,closed,po_converted,lost',
            'salesman_id' => 'required|exists:users,id',
            'quotation_code' => 'required|string|unique:quotations,quotation_code',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.hsn' => 'nullable|string|max:100',
            'items.*.sku' => 'nullable|string|max:100',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:percentage,fixed',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.description' => 'nullable|string',
            'expire_date' => 'nullable|date',
            'reference' => 'nullable|string|max:255',
            'reference_no' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date',
            'tax_type' => 'nullable|string|max:50',
            'tax_regime' => 'nullable|string|in:cgst_sgst,igst',
            'payment_terms' => 'nullable|string',
            'description' => 'nullable|string',
            'enquiry_id' => 'nullable|exists:enquiries,id',
            'round_off' => 'nullable|numeric',
            'other_charges' => 'nullable|array',
            'other_charges_total' => 'nullable|numeric',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation Errors:', $validator->errors()->toArray());
            \Log::error('Failed Validation Data:', $request->all());
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
            
            // Calculate totals with PROPER TYPE CASTING
            $subtotal = (float)($request->subtotal ?? 0);
            $totalCgst = (float)($request->cgst ?? 0);
            $totalSgst = (float)($request->sgst ?? 0);
            $totalIgst = (float)($request->igst ?? 0);
            $totalDiscount = (float)($request->total_discount ?? 0);
            $grandTotal = (float)($request->grand_total ?? 0);
            $totalItems = count($request->items);
            $totalQuantity = (float)array_sum(array_column($request->items, 'quantity'));
            
            // IMPORTANT: Cast all decimal values properly
            $taxableAmount = is_numeric($request->taxable_amount) ? (float)$request->taxable_amount : 0;
            $totalTax = is_numeric($request->total_tax) ? (float)$request->total_tax : 0;
            $roundOff = is_numeric($request->round_off) ? (float)$request->round_off : 0;
            $otherChargesTotal = is_numeric($request->other_charges_total) ? (float)$request->other_charges_total : 0;
            
            // Parse other charges JSON if exists
            $otherCharges = [];
            if ($request->has('other_charges') && !empty($request->other_charges)) {
                if (is_string($request->other_charges)) {
                    $otherCharges = json_decode($request->other_charges, true);
                } else {
                    $otherCharges = $request->other_charges;
                }
            }
            
            // Create quotation
            $quotation = new Quotation();
            $quotation->quotation_code = $request->quotation_code;
            $quotation->customer_id = $request->customer_id;
            $quotation->customer_name = $customer->name;
            $quotation->customer_email = $customer->email ?? null;
            $quotation->customer_mobile = $customer->mobile ?? null;
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
            
            // Total fields - ALL must be proper decimals
            $quotation->subtotal = $subtotal;
            $quotation->total_discount = $totalDiscount;
            $quotation->taxable_amount = $taxableAmount;
            $quotation->cgst = $totalCgst;
            $quotation->sgst = $totalSgst;
            $quotation->igst = $totalIgst;
            $quotation->total_tax = $totalTax;
            $quotation->grand_total = $grandTotal;
            $quotation->total_items = $totalItems;
            $quotation->total_quantity = $totalQuantity;
            $quotation->round_off = $roundOff;
            $quotation->other_charges_total = $otherChargesTotal;
            
            // Store other charges as JSON
            if (!empty($otherCharges)) {
                $quotation->other_charges = json_encode($otherCharges);
            } else {
                $quotation->other_charges = null; // Or empty string
            }
            
            $quotation->description = $request->description;
            $quotation->created_by = Auth::id();
            $quotation->company_id = Auth::user()->creatorId();
            
            // Add enquiry reference if exists
            if ($request->has('enquiry_id')) {
                $quotation->enquiry_id = $request->enquiry_id;
            }
            
            \Log::info('Saving quotation with data:', $quotation->toArray());
            
            if (!$quotation->save()) {
                throw new \Exception('Failed to save quotation');
            }
            
            \Log::info('Quotation saved with ID: ' . $quotation->id);
            
            // Save items
            foreach($request->items as $index => $itemData) {
                if(!empty($itemData['item_id'])) {
                    \Log::info("Saving item {$index}: ", $itemData);
                    
                    // Get item name from Items table
                    $item = Items::find($itemData['item_id']);
                    $itemName = $item ? $item->name : 'Item ' . $itemData['item_id'];
                    
                    $quotationItem = new QuotationItem();
                    $quotationItem->quotation_id = $quotation->id;
                    $quotationItem->item_id = $itemData['item_id']; // Store item ID
                    $quotationItem->item_name = $itemName;
                    $quotationItem->description = $itemData['description'] ?? '';
                    
                    // Store HSN and SKU
                    $quotationItem->hsn_code = $itemData['hsn'] ?? '';
                    $quotationItem->sku = $itemData['sku'] ?? '';
                    
                    $quotationItem->quantity = (float)($itemData['quantity'] ?? 0);
                    $quotationItem->unit_price = (float)($itemData['unit_price'] ?? 0);
                    $quotationItem->discount = (float)($itemData['discount'] ?? 0);
                    
                    // Fix: Convert 'percentage' to 'percent' if needed
                    $discountType = $itemData['discount_type'] ?? 'percentage';
                    if ($discountType === 'percentage') {
                        $quotationItem->discount_type = 'percent';
                    } else {
                        $quotationItem->discount_type = $discountType;
                    }
                    
                    // Store tax percentage
                    $taxPercentage = (float)($itemData['tax_percentage'] ?? 18);
                    $quotationItem->tax_percentage = $taxPercentage;
                    
                    // Calculate tax rates
                    if($gstType === 'cgst_sgst') {
                        $quotationItem->cgst_rate = $taxPercentage / 2;
                        $quotationItem->sgst_rate = $taxPercentage / 2;
                        $quotationItem->igst_rate = 0;
                    } else {
                        $quotationItem->cgst_rate = 0;
                        $quotationItem->sgst_rate = 0;
                        $quotationItem->igst_rate = $taxPercentage;
                    }
                    
                    // Calculate total
                    $quantity = (float)($itemData['quantity'] ?? 0);
                    $unitPrice = (float)($itemData['unit_price'] ?? 0);
                    $discount = (float)($itemData['discount'] ?? 0);
                    $discountType = $itemData['discount_type'] ?? 'percentage';
                    
                    $itemSubtotal = $quantity * $unitPrice;
                    $discountAmount = 0;
                    
                    if ($discountType === 'percentage') {
                        $discountAmount = ($itemSubtotal * $discount) / 100;
                    } else {
                        $discountAmount = $discount;
                    }
                    
                    $taxableAmount = $itemSubtotal - $discountAmount;
                    $taxAmount = ($taxableAmount * $taxPercentage) / 100;
                    $totalAmount = $taxableAmount + $taxAmount;
                    
                    $quotationItem->total_amount = $totalAmount;
                    $quotationItem->tax_amount = $taxAmount;
                    
                    // Store additional calculated fields
                    $quotationItem->subtotal = $itemSubtotal;
                    $quotationItem->discount_amount = $discountAmount;
                    $quotationItem->taxable_amount = $taxableAmount;
                    
                    if (!$quotationItem->save()) {
                        \Log::error('Failed to save quotation item:', $itemData);
                        throw new \Exception('Failed to save quotation item: ' . $itemName);
                    }
                    
                    \Log::info("Item {$index} saved successfully with ID: " . $quotationItem->id);
                }
            }
            
            DB::commit();
            \Log::info('=== QUOTATION STORE COMPLETED SUCCESSFULLY ===');
            
            // Clear the converted enquiry session data
            session()->forget('converted_enquiry');
            
            return redirect()->route('quotation.index')->with('success', __('Quotation created successfully.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Quotation Creation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Log the actual error details
            if (strpos($e->getMessage(), 'Unable to cast value') !== false) {
                \Log::error('Decimal casting error. Check these values:');
                \Log::error('taxable_amount: ' . ($request->taxable_amount ?? 'null'));
                \Log::error('total_tax: ' . ($request->total_tax ?? 'null'));
                \Log::error('other_charges_total: ' . ($request->other_charges_total ?? 'null'));
                \Log::error('round_off: ' . ($request->round_off ?? 'null'));
            }
            
            return redirect()->back()
                ->with('error', __('Error creating quotation: ') . $e->getMessage())
                ->withInput();
        }
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}
// Add this helper method to update Item model
private function updateItemDetails($itemData)
{
    try {
        \Log::info('=== UPDATE ITEM DETAILS STARTED ===');
        \Log::info('Item data received:', $itemData);
        
        // First, try to find the item by ID
        $itemId = null;
        
        // Check if item_id is numeric (ID)
        if (isset($itemData['item_id']) && is_numeric($itemData['item_id'])) {
            $itemId = $itemData['item_id'];
        } 
        // If not numeric, it might be a string - try to find by name
        elseif (isset($itemData['item_id']) && is_string($itemData['item_id'])) {
            // Try to extract ID from string (if format is "ID: Name")
            if (preg_match('/^(\d+):/', $itemData['item_id'], $matches)) {
                $itemId = $matches[1];
            } else {
                // Try to find by name
                $item = Items::where('name', $itemData['item_id'])->first();
                if ($item) {
                    $itemId = $item->id;
                }
            }
        }
        
        if (!$itemId) {
            \Log::warning('Could not determine item ID from data:', $itemData);
            return false;
        }
        
        $item = Items::find($itemId);
        
        if (!$item) {
            \Log::error('Item not found with ID: ' . $itemId);
            return false;
        }
        
        \Log::info('Found item: ' . $item->name . ' (ID: ' . $item->id . ')');
        \Log::info('Current item data:', [
            'hsn' => $item->hsn,
            'sku' => $item->sku,
            'description' => $item->description,
            'sales_price' => $item->sales_price,
            'discount' => $item->discount,
            'discount_type' => $item->discount_type,
            'tax_type' => $item->tax_type,
        ]);
        
        $updated = false;
        
        // Update HSN if provided and different
        if (isset($itemData['hsn']) && !empty($itemData['hsn']) && $item->hsn != $itemData['hsn']) {
            \Log::info('Updating HSN from "' . $item->hsn . '" to "' . $itemData['hsn'] . '"');
            $item->hsn = $itemData['hsn'];
            $updated = true;
        }
        
        // Update SKU if provided and different
        if (isset($itemData['sku']) && !empty($itemData['sku']) && $item->sku != $itemData['sku']) {
            \Log::info('Updating SKU from "' . $item->sku . '" to "' . $itemData['sku'] . '"');
            $item->sku = $itemData['sku'];
            $updated = true;
        }
        
        // Update description if provided and different
        if (isset($itemData['description']) && !empty($itemData['description']) && $item->description != $itemData['description']) {
            \Log::info('Updating description from "' . substr($item->description, 0, 50) . '..." to "' . substr($itemData['description'], 0, 50) . '..."');
            $item->description = $itemData['description'];
            $updated = true;
        }
        
        // Update discount if provided and different
        if (isset($itemData['discount']) && $itemData['discount'] != '' && $item->discount != $itemData['discount']) {
            \Log::info('Updating discount from "' . $item->discount . '" to "' . $itemData['discount'] . '"');
            $item->discount = $itemData['discount'];
            $updated = true;
        }
        
        // Update discount type if provided and different
        if (isset($itemData['discount_type']) && !empty($itemData['discount_type']) && $item->discount_type != $itemData['discount_type']) {
            \Log::info('Updating discount_type from "' . $item->discount_type . '" to "' . $itemData['discount_type'] . '"');
            $item->discount_type = $itemData['discount_type'];
            $updated = true;
        }
        
        // Update sales price if provided and different
        if (isset($itemData['unit_price']) && $itemData['unit_price'] > 0 && $item->sales_price != $itemData['unit_price']) {
            \Log::info('Updating sales_price from "' . $item->sales_price . '" to "' . $itemData['unit_price'] . '"');
            $item->sales_price = $itemData['unit_price'];
            $updated = true;
        }
        
        // NOTE: Your table doesn't have tax_rate column, it has tax_type
        // If you want to store tax percentage, you might need to add a tax_rate column
        // Or use a different approach
        
        // For now, let's log what tax percentage was sent
        if (isset($itemData['tax_percentage'])) {
            \Log::info('Tax percentage sent in request: ' . $itemData['tax_percentage'] . '%');
            \Log::info('Note: Items table only has tax_type column, not tax_rate column');
        }
        
        if ($updated) {
            try {
                if ($item->save()) {
                    \Log::info("Successfully updated Item model for item ID: {$itemId}");
                    \Log::info('Updated item data:', [
                        'hsn' => $item->hsn,
                        'sku' => $item->sku,
                        'description' => $item->description,
                        'sales_price' => $item->sales_price,
                        'discount' => $item->discount,
                        'discount_type' => $item->discount_type,
                    ]);
                    return true;
                } else {
                    \Log::error("Failed to save Item model for item ID: {$itemId}");
                    return false;
                }
            } catch (\Exception $e) {
                \Log::error('Error saving item: ' . $e->getMessage());
                \Log::error('Error details: ' . $e->getTraceAsString());
                return false;
            }
        } else {
            \Log::info("No changes needed for item ID: {$itemId}");
            return true;
        }
        
    } catch (\Exception $e) {
        \Log::error('Error updating item details: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return false;
    }
}

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::with(['items', 'salesman', 'customer'])->findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        // Format amount in words
        $amountInWords = $this->numberToWords($quotation->grand_total);
        
        return view('quotation.show', compact('quotation', 'amountInWords'));
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}
// Add this to a helper file or in your controller
public function numberToWords($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}
   /**
 * Show the form for editing the specified resource.
 */
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
        
        // Get items from Items module
        $itemsModel = '\App\Models\Items';
        $items = [];
        $itemDetails = [];
        
        if (class_exists($itemsModel)) {
            $itemRecords = $itemsModel::where('created_by', Auth::user()->creatorId())
                                ->where('deleted_at', NULL)
                                ->orderBy('name')
                                ->get();
            
            // Prepare items array for dropdown
            foreach ($itemRecords as $item) {
                $items[$item->id] = $item->name;
                $itemDetails[$item->id] = [
                    'hsn' => $item->hsn ?? '',
                    'sku' => $item->sku ?? '',
                    'discount' => $item->discount ?? 0,
                    'description' => $item->description ?? '',
                    'discount_type' => $item->discount_type ?? 'percentage',
                    'price' => $item->sales_price ?? 0,
                    'tax_rate' => $item->tax_rate ?? 18
                ];
            }
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
        
        // Decode other charges if exists
        $otherCharges = json_decode($quotation->other_charges, true) ?? [];
        
        return view('quotation.edit', compact(
            'quotation', 
            'customers', 
            'salesmen', 
            'items',
            'itemDetails',
            'otherCharges'
        ));
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
        \Log::info('User ID: ' . Auth::id());
        \Log::info('Quotation ID: ' . $id);
        \Log::info('Request Data:', $request->all());
        
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'contact_person' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'status' => 'required|string|in:open,closed,po_converted,lost',
            'salesman_id' => 'required|exists:users,id',
            'quotation_code' => 'required|string|unique:quotations,quotation_code,' . $id,
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.hsn' => 'nullable|string|max:100',
            'items.*.sku' => 'nullable|string|max:100',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:percentage,fixed',
            'items.*.tax_percentage' => 'nullable|numeric|min:0|max:100',
            'items.*.description' => 'nullable|string',
            'expire_date' => 'nullable|date',
            'reference' => 'nullable|string|max:255',
            'reference_no' => 'nullable|string|max:255',
            'reference_date' => 'nullable|date',
            'tax_type' => 'nullable|string|max:50',
            'tax_regime' => 'nullable|string|in:cgst_sgst,igst',
            'payment_terms' => 'nullable|string',
            'description' => 'nullable|string',
            'round_off' => 'nullable|numeric',
            'other_charges' => 'nullable|array',
            'other_charges_total' => 'nullable|numeric',
        ]);
        
        if ($validator->fails()) {
            \Log::error('Validation Errors:', $validator->errors()->toArray());
            \Log::error('Failed Validation Data:', $request->all());
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
            
            // Calculate totals with PROPER TYPE CASTING
            $subtotal = (float)($request->subtotal ?? 0);
            $totalCgst = (float)($request->cgst ?? 0);
            $totalSgst = (float)($request->sgst ?? 0);
            $totalIgst = (float)($request->igst ?? 0);
            $totalDiscount = (float)($request->total_discount ?? 0);
            $grandTotal = (float)($request->grand_total ?? 0);
            $totalItems = count($request->items);
            $totalQuantity = (float)array_sum(array_column($request->items, 'quantity'));
            
            // IMPORTANT: Cast all decimal values properly
            $taxableAmount = is_numeric($request->taxable_amount) ? (float)$request->taxable_amount : 0;
            $totalTax = is_numeric($request->total_tax) ? (float)$request->total_tax : 0;
            $roundOff = is_numeric($request->round_off) ? (float)$request->round_off : 0;
            $otherChargesTotal = is_numeric($request->other_charges_total) ? (float)$request->other_charges_total : 0;
            
            // Parse other charges JSON if exists
            $otherCharges = [];
            if ($request->has('other_charges') && !empty($request->other_charges)) {
                if (is_string($request->other_charges)) {
                    $otherCharges = json_decode($request->other_charges, true);
                } else {
                    $otherCharges = $request->other_charges;
                }
            }
            
            // Update quotation
            $quotation->quotation_code = $request->quotation_code;
            $quotation->customer_id = $request->customer_id;
            $quotation->customer_name = $customer->name;
            $quotation->customer_email = $customer->email ?? null;
            $quotation->customer_mobile = $customer->mobile ?? null;
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
            
            // Total fields - ALL must be proper decimals
            $quotation->subtotal = $subtotal;
            $quotation->total_discount = $totalDiscount;
            $quotation->taxable_amount = $taxableAmount;
            $quotation->cgst = $totalCgst;
            $quotation->sgst = $totalSgst;
            $quotation->igst = $totalIgst;
            $quotation->total_tax = $totalTax;
            $quotation->grand_total = $grandTotal;
            $quotation->total_items = $totalItems;
            $quotation->total_quantity = $totalQuantity;
            $quotation->round_off = $roundOff;
            $quotation->other_charges_total = $otherChargesTotal;
            
            // Store other charges as JSON
            if (!empty($otherCharges)) {
                $quotation->other_charges = json_encode($otherCharges);
            } else {
                $quotation->other_charges = null;
            }
            
            $quotation->description = $request->description;
  
            \Log::info('Updating quotation with data:', $quotation->toArray());
            
            if (!$quotation->save()) {
                throw new \Exception('Failed to update quotation');
            }
            
            \Log::info('Quotation updated with ID: ' . $quotation->id);
            
            // Delete existing items
            QuotationItem::where('quotation_id', $quotation->id)->delete();
            
            // Save items and update Item model if requested
            foreach($request->items as $index => $itemData) {
                if(!empty($itemData['item_id'])) {
                    \Log::info("Saving item {$index}: ", $itemData);
                    
                    // Check if we need to update the Item model
                    if ($request->has('update_item_details') && $request->update_item_details == '1') {
                        $this->updateItemDetails($itemData);
                    }
                    
                    // Get item name from Items table
                    $item = Items::find($itemData['item_id']);
                    $itemName = $item ? $item->name : 'Item ' . $itemData['item_id'];
                    
                    $quotationItem = new QuotationItem();
                    $quotationItem->quotation_id = $quotation->id;
                    $quotationItem->item_id = $itemData['item_id']; // Store item ID
                    $quotationItem->item_name = $itemName;
                    $quotationItem->description = $itemData['description'] ?? '';
                    
                    // Store HSN and SKU
                    $quotationItem->hsn_code = $itemData['hsn'] ?? '';
                    $quotationItem->sku = $itemData['sku'] ?? '';
                    
                    $quotationItem->quantity = (float)($itemData['quantity'] ?? 0);
                    $quotationItem->unit_price = (float)($itemData['unit_price'] ?? 0);
                    $quotationItem->discount = (float)($itemData['discount'] ?? 0);
                    
                    // Fix: Convert 'percentage' to 'percent' if needed
                    $discountType = $itemData['discount_type'] ?? 'percentage';
                    if ($discountType === 'percentage') {
                        $quotationItem->discount_type = 'percent';
                    } else {
                        $quotationItem->discount_type = $discountType;
                    }
                    
                    // Store tax percentage
                    $taxPercentage = (float)($itemData['tax_percentage'] ?? 18);
                    $quotationItem->tax_percentage = $taxPercentage;
                    
                    // Calculate tax rates
                    if($gstType === 'cgst_sgst') {
                        $quotationItem->cgst_rate = $taxPercentage / 2;
                        $quotationItem->sgst_rate = $taxPercentage / 2;
                        $quotationItem->igst_rate = 0;
                    } else {
                        $quotationItem->cgst_rate = 0;
                        $quotationItem->sgst_rate = 0;
                        $quotationItem->igst_rate = $taxPercentage;
                    }
                    
                    // Calculate total
                    $quantity = (float)($itemData['quantity'] ?? 0);
                    $unitPrice = (float)($itemData['unit_price'] ?? 0);
                    $discount = (float)($itemData['discount'] ?? 0);
                    $discountType = $itemData['discount_type'] ?? 'percentage';
                    
                    $itemSubtotal = $quantity * $unitPrice;
                    $discountAmount = 0;
                    
                    if ($discountType === 'percentage') {
                        $discountAmount = ($itemSubtotal * $discount) / 100;
                    } else {
                        $discountAmount = $discount;
                    }
                    
                    $taxableAmount = $itemSubtotal - $discountAmount;
                    $taxAmount = ($taxableAmount * $taxPercentage) / 100;
                    $totalAmount = $taxableAmount + $taxAmount;
                    
                    $quotationItem->total_amount = $totalAmount;
                    $quotationItem->tax_amount = $taxAmount;
                    
                    // Store additional calculated fields
                    $quotationItem->subtotal = $itemSubtotal;
                    $quotationItem->discount_amount = $discountAmount;
                    $quotationItem->taxable_amount = $taxableAmount;
                    
                    if (!$quotationItem->save()) {
                        \Log::error('Failed to save quotation item:', $itemData);
                        throw new \Exception('Failed to save quotation item: ' . $itemName);
                    }
                    
                    \Log::info("Item {$index} saved successfully with ID: " . $quotationItem->id);
                }
            }
            
            DB::commit();
            \Log::info('=== QUOTATION UPDATE COMPLETED SUCCESSFULLY ===');
            
            return redirect()->route('quotation.index')->with('success', __('Quotation updated successfully.'));
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Quotation Update Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Log the actual error details
            if (strpos($e->getMessage(), 'Unable to cast value') !== false) {
                \Log::error('Decimal casting error. Check these values:');
                \Log::error('taxable_amount: ' . ($request->taxable_amount ?? 'null'));
                \Log::error('total_tax: ' . ($request->total_tax ?? 'null'));
                \Log::error('other_charges_total: ' . ($request->other_charges_total ?? 'null'));
                \Log::error('round_off: ' . ($request->round_off ?? 'null'));
            }
            
            return redirect()->back()
                ->with('error', __('Error updating quotation: ') . $e->getMessage())
                ->withInput();
        }
    }
    
    return redirect()->back()->with('error', __('Permission denied.'));
}/**
 * Get item details via AJAX
 */
public function getItemDetails(Request $request)
{
    try {
        $itemId = $request->item_id;
        $item = Items::find($itemId);
        
        if ($item) {
            // Your table doesn't have tax_rate, so return a default or null
            // If you need tax rate, you might want to add it to the table
            return response()->json([
                'success' => true,
                'price' => $item->sales_price ?? 0,
                'hsn' => $item->hsn ?? '',
                'sku' => $item->sku ?? '',
                'description' => $item->description ?? '',
                'tax_rate' => 18, // Default since table doesn't have this column
                'discount' => $item->discount ?? 0,
                'discount_type' => $item->discount_type ?? 'percentage',
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in getItemDetails: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error'
        ]);
    }
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
                  
  // In QuotationController.php
public function print($id)
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        $quotation = Quotation::with(['items', 'salesman', 'customer'])->findOrFail($id);
        
        // Check if quotation belongs to current company
        if($quotation->company_id != Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        // Format amount in words
        $amountInWords = $this->numberToWords($quotation->grand_total);
        
        // Pass company info from authenticated user
        $company_info = [
            'company_name' => \Auth::user()->company_name ?? 'Company Name',
            'company_address' => \Auth::user()->company_address ?? 'Company Address',
            'company_city' => \Auth::user()->company_city ?? 'City',
            'company_state' => \Auth::user()->company_state ?? 'State',
            'company_zip_code' => \Auth::user()->company_zip_code ?? 'ZIP Code',
            'company_email' => \Auth::user()->company_email ?? 'Email',
            'company_phone' => \Auth::user()->company_phone ?? 'Phone',
            'company_gstin' => \Auth::user()->company_gstin ?? 'GST Number',
            'company_logo' => \Auth::user()->company_logo ?? null,
        ];
        
        return view('quotation.print', compact('quotation', 'amountInWords') + $company_info);
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