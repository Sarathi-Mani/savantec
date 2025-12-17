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

public function create()
{
    if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
    {
        // Check if coming from enquiry conversion
        $enquiryData = session('converted_enquiry');
        
        // Get customers (companies) - assuming Customer model is your companies
        $customers = Customer::where('created_by', Auth::user()->creatorId())
                             ->where('is_active', '1')
                             ->orderBy('name')
                             ->get();
        
        // If coming from enquiry, pre-select the customer
        if ($enquiryData) {
          $selectedCustomer = null;

if ($enquiryData) {
    $selectedCustomer = Customer::where('name', $enquiryData['company_name'])
        ->orWhere('email', $enquiryData['mail_id'])
        ->first();
}

        }
        
        $salesmen = User::where('type', 'sales enginner')
                        ->where('is_active', 1)
                        ->pluck('name', 'id');
        
        if($salesmen->isEmpty()) {
            $salesmen = User::where('type', '!=', 'company')
                            ->where('is_active', 1)
                            ->pluck('name', 'id');
        }
        
        // Get default items for dropdown
        $items = [
            1 => 'Office Chair',
            2 => 'Office Desk', 
            3 => 'Computer Monitor',
            4 => 'Keyboard & Mouse',
            5 => 'Conference Table'
        ];
        
        // Generate quotation code
        $lastQuotation = Quotation::orderBy('id', 'desc')->first();
        $quotationCode = 'QUOT-' . date('Ymd') . '-0001';
        
        if ($lastQuotation && !empty($lastQuotation->quotation_code)) {
            if (preg_match('/QUOT-\d{8}-(\d{4})/', $lastQuotation->quotation_code, $matches)) {
                $lastNumber = (int)$matches[1];
                $nextNumber = $lastNumber + 1;
                $quotationCode = 'QUOT-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        }
        
       return view('quotation.create', compact(
    'customers',
    'salesmen',
    'items',
    'quotationCode',
    'enquiryData',
    'selectedCustomer'
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin')
        {
            // Enable debug logging
            
            // Manually validate first to see errors
            $validator = \Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'contact_person' => 'required|string|max:255',
                'quotation_date' => 'required|date',
                'status' => 'required|string|in:open,closed,po_converted,lost',
                'salesman_id' => 'required|exists:users,id',
                'quotation_code' => 'required|string|unique:quotations,quotation_code',
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
                
                // Convert date format from d-m-Y to Y-m-d
                $quotationDate = null;
                if ($request->quotation_date) {
                    $quotationDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->quotation_date)->format('Y-m-d');
                }
                
                // Convert other dates if they exist
                $expireDate = null;
                if ($request->expire_date) {
                    $expireDate = \Carbon\Carbon::parse($request->expire_date)->format('Y-m-d');
                }
                
                $referenceDate = null;
                if ($request->reference_date) {
                    $referenceDate = \Carbon\Carbon::parse($request->reference_date)->format('Y-m-d');
                }
                
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
                $quotation->quotation_date = $quotationDate; // Use converted date
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
                        $quotationItem->item_name = $itemData['item_id'];
                        $quotationItem->description = $itemData['description'] ?? '';
                        $quotationItem->quantity = $itemData['quantity'] ?? 0;
                        $quotationItem->unit_price = $itemData['unit_price'] ?? 0;
                        $quotationItem->discount = $itemData['discount'] ?? 0;
                        $quotationItem->discount_type = $itemData['discount_type'] ?? 'percent';
                        $quotationItem->cgst_rate = $itemData['cgst_rate'] ?? 0;
                        $quotationItem->sgst_rate = $itemData['sgst_rate'] ?? 0;
                        $quotationItem->igst_rate = $itemData['igst_rate'] ?? 0;
                        
                        // Convert total_amount from formatted string to number
                        $totalAmount = $itemData['total_amount'] ?? '0.00';
                        if (is_string($totalAmount)) {
                            $totalAmount = (float) preg_replace('/[^0-9.-]+/', '', $totalAmount);
                        }
                        $quotationItem->total_amount = $totalAmount;
                        
                        if (!$quotationItem->save()) {
                            \Log::error('Failed to save quotation item:', $itemData);
                            throw new \Exception('Failed to save quotation item: ' . $itemData['item_name']);
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
            
            $items = [
                1 => 'Office Chair',
                2 => 'Office Desk', 
                3 => 'Computer Monitor',
                4 => 'Keyboard & Mouse',
                5 => 'Conference Table'
            ];
            
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
            
            // Similar validation and update logic as store method
            // You can copy the store method logic here
            
            return redirect()->route('quotation.index')->with('success', __('Quotation updated successfully.'));
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