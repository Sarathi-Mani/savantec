<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnquiryController extends Controller
{
   public function index(Request $request)
    {
        if(\Auth::user()->can('enquiry_add') || \Auth::user()->can('enquiry_view'))
        {
            $user = \Auth::user();
            
            $query = Enquiry::with(['salesman', 'company']);
            
            // Apply filters
            if ($request->filled('from_date')) {
                $query->whereDate('enquiry_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('enquiry_date', '<=', $request->to_date);
            }
            
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }
            
            if ($request->filled('salesman_id')) {
                $query->where('salesman_id', $request->salesman_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('serial_no', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhere('kind_attn', 'like', "%{$search}%")
                      ->orWhere('mail_id', 'like', "%{$search}%")
                      ->orWhere('phone_no', 'like', "%{$search}%")
                      ->orWhere('remarks', 'like', "%{$search}%")
                      ->orWhereHas('salesman', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($user->hasRole('Sales Engineer')) {
                $query->where('salesman_id', $user->id);
            }
            elseif ($user->type != 'super admin') {
                $query->where('created_by', $user->creatorId());
            }
            
            $perPage = $request->get('per_page', 10);
            $enquiries = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // FIXED: Get companies with type='company' and proper status
            $companies = User::where('type', 'company')
                ->where(function($query) {
                    $query->where('delete_status', 1)  // Active companies (not deleted)
                          ->orWhereNull('delete_status');  // Or companies where delete_status is not set
                })
                ->where('is_active', 1)  // Active companies only
                ->when($user->type != 'super admin', function ($query) use ($user) {
                    return $query->where('created_by', $user->creatorId());
                })
                ->get()
                ->pluck('name', 'id');
            
            // Get salesmen
            $salesmen = User::where('is_active', 1)
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'sales engineer');
                })
                ->when($user->type != 'super admin', function ($query) use ($user) {
                    return $query->where('created_by', $user->creatorId());
                })
                ->get()
                ->pluck('name', 'id');
                
            
            // Check if request is AJAX
            if ($request->ajax()) {
                return view('enquiry.partials.table', compact('enquiries'))->render();
            }
            
            return view('enquiry.index', compact('enquiries', 'companies', 'salesmen'));
        }
        else
        {
            if ($request->ajax()) {
                return response()->json(['error' => __('Permission denied.')], 403);
            }
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // Add CSV export method
    public function exportCsv(Request $request)
    {
        if(\Auth::user()->can('enquiry_view'))
        {
            $user = \Auth::user();
            
            $query = Enquiry::with(['salesman', 'company']);
            
            // Apply filters (same as index method)
            if ($request->filled('from_date')) {
                $query->whereDate('enquiry_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('enquiry_date', '<=', $request->to_date);
            }
            
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }
            
            if ($request->filled('salesman_id')) {
                $query->where('salesman_id', $request->salesman_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('serial_no', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhere('kind_attn', 'like', "%{$search}%")
                      ->orWhereHas('salesman', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($user->hasRole('Sales Engineer')) {
                $query->where('salesman_id', $user->id);
            }
            elseif ($user->type != 'super admin') {
                $query->where('created_by', $user->creatorId());
            }
            
            $enquiries = $query->orderBy('created_at', 'desc')->get();
            
            $fileName = 'enquiries_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$fileName\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];
            
            $columns = [
                __('S.No'),
                __('Enquiry No'),
                __('Enquiry Date'),
                __('Company Name'),
                __('Kind Attention'),
                __('Email'),
                __('Phone'),
                __('Sales Engineer'),
                __('Status'),
                __('Quantity'),
                __('Assigned Date'),
                __('Quotation Date'),
                __('Purchase Date'),
                __('Remarks')
            ];
            
            $callback = function() use ($enquiries, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                
                $i = 1;
                foreach ($enquiries as $enquiry) {
                    $row = [
                        $i++,
                        $enquiry->serial_no,
                        $enquiry->enquiry_date ? \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y') : '',
                        $enquiry->company_name,
                        $enquiry->kind_attn,
                        $enquiry->mail_id,
                        $enquiry->phone_no,
                        $enquiry->salesman ? $enquiry->salesman->name : '',
                        ucfirst($enquiry->status),
                        $enquiry->qty,
                        $enquiry->assigned_date_time ? \Carbon\Carbon::parse($enquiry->assigned_date_time)->format('d-m-Y H:i:s') : '',
                        $enquiry->quotation_date_time ? \Carbon\Carbon::parse($enquiry->quotation_date_time)->format('d-m-Y H:i:s') : '',
                        $enquiry->purchase_date_time ? \Carbon\Carbon::parse($enquiry->purchase_date_time)->format('d-m-Y H:i:s') : '',
                        $enquiry->remarks
                    ];
                    
                    fputcsv($file, $row);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // Add print method
    public function print(Request $request)
    {
        if(\Auth::user()->can('enquiry_view'))
        {
            $user = \Auth::user();
            
            $query = Enquiry::with(['salesman', 'company']);
            
            // Apply filters (same as index method)
            if ($request->filled('from_date')) {
                $query->whereDate('enquiry_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('enquiry_date', '<=', $request->to_date);
            }
            
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }
            
            if ($request->filled('salesman_id')) {
                $query->where('salesman_id', $request->salesman_id);
            }
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('serial_no', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhere('kind_attn', 'like', "%{$search}%")
                      ->orWhereHas('salesman', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            if ($user->hasRole('Sales Engineer')) {
                $query->where('salesman_id', $user->id);
            }
            elseif ($user->type != 'super admin') {
                $query->where('created_by', $user->creatorId());
            }
            
            $enquiries = $query->orderBy('created_at', 'desc')->get();
            
            return view('enquiry.print', compact('enquiries'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // Rest of your existing methods remain the same...
  public function create()
{
    if(\Auth::user()->can('enquiry_add'))
    {
        $user = \Auth::user();

        // Get salesmen
        $salesmen = User::where('is_active', 1)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Sales Engineer');
            })
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->get()
            ->pluck('name', 'id');

        // Get companies from users table where type = 'company'
        $companies = User::where('type', 'company')
            ->where('is_active', 1)
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->get()
            ->pluck('name', 'id');

        // Get items from Items model for dropdown
        $items = \App\Models\Items::where('deleted_at', NULL)
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'description']);

        // Get the last enquiry number and increment it
        $lastEnquiry = Enquiry::orderBy('id', 'desc')->first();
        $suggestedSerial = 'ENQ-' . date('Ymd') . '-0001';
        
        if ($lastEnquiry && !empty($lastEnquiry->serial_no)) {
            $lastSerial = $lastEnquiry->serial_no;
            
            if (preg_match('/ENQ-\d{8}-(\d{4})/', $lastSerial, $matches)) {
                $lastNumber = (int)$matches[1];
                $nextNumber = $lastNumber + 1;
                $suggestedSerial = 'ENQ-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else if (preg_match('/(\d+)$/', $lastSerial, $matches)) {
                $lastNumber = (int)$matches[1];
                $nextNumber = $lastNumber + 1;
                $suggestedSerial = $nextNumber;
            } else if (is_numeric($lastSerial)) {
                $nextNumber = (int)$lastSerial + 1;
                $suggestedSerial = $nextNumber;
            }
        }

        return view('enquiry.create', compact('salesmen', 'companies', 'suggestedSerial', 'items'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

public function store(Request $request)
{
    if(\Auth::user()->can('enquiry_add'))
    {
        // Custom validation for items array
        $validator = \Validator::make($request->all(), [
            'enquiry_no' => 'required|string|max:100|unique:enquiries,serial_no',
            'enquiry_date' => 'required|date',
            'company_id' => 'required|exists:users,id',
            'kind_attn' => 'nullable|string|max:255',
            'mail_id' => 'nullable|email|max:255',
            'phone_no' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
            'salesman_id' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,completed,ready for quotation,ready for purchased,ignored',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get company name from users table
        $company = User::where('id', $request->company_id)
            ->where('type', 'company')
            ->first();
        
        // Use the custom serial number entered by user
        $serialNumber = $request->enquiry_no;
        
        // Calculate total quantity from all items
        $totalQty = 0;
        $items = [];
        
        if ($request->has('items')) {
            foreach ($request->items as $index => $itemData) {
                // Skip if description is empty
                if (empty(trim($itemData['description']))) {
                    continue;
                }
                
                $itemQuantity = isset($itemData['quantity']) ? (int)$itemData['quantity'] : 1;
                $totalQty += $itemQuantity;
                
                $item = [
                    'item_id' => $itemData['item_id'] ?? null,
                    'description' => trim($itemData['description']),
                    'quantity' => $itemQuantity,
                    'image' => null
                ];
                
                // Handle image upload for each item
                if ($request->hasFile("items.$index.image")) {
                    $imageFile = $request->file("items.$index.image");
                    
                    if ($imageFile->isValid()) {
                        // Generate unique filename
                        $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                        
                        // Store the image in public storage
                        $imagePath = $imageFile->storeAs('enquiry_items', $imageName, 'public');
                        
                        // Store only the filename in database
                        $item['image'] = $imageName;
                    }
                }
                
                $items[] = $item;
            }
        }
        
        // If no valid items after processing
        if (empty($items)) {
            return redirect()->back()
                ->with('error', 'At least one item with description is required')
                ->withInput();
        }
        
        $enquiry = Enquiry::create([
            'serial_no' => $serialNumber,
            'enquiry_date' => $request->enquiry_date,
            'company_id' => $request->company_id,
            'company_name' => $company ? $company->name : null,
            'kind_attn' => $request->kind_attn,
            'mail_id' => $request->mail_id,
            'phone_no' => $request->phone_no,
            'remarks' => $request->remarks,
            'items' => json_encode($items),
            'qty' => $totalQty,
            'salesman_id' => $request->salesman_id ?: \Auth::id(),
            'status' => $request->status,
            'created_by' => \Auth::user()->id,
        ]);
        
        return redirect()->route('enquiry.index')->with('success', __('Enquiry created successfully.'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

    public function show($id)
    {
        if(\Auth::user()->can('enquiry_view'))
        {
            $enquiry = Enquiry::with(['salesman', 'createdBy', 'company'])->findOrFail($id);
            
            // Sales Engineer can only view their own enquiries
            if (\Auth::user()->hasRole('Sales Engineer') && $enquiry->salesman_id != \Auth::id()) {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
            
            return view('enquiry.show', compact('enquiry'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

  public function edit($id)
{
    if(\Auth::user()->can('enquiry_edit'))
    {
        $enquiry = Enquiry::findOrFail($id);
        
        $user = \Auth::user();

        // Get salesmen
        $salesmen = User::where('is_active', 1)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Sales Engineer');
            })
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->get()
            ->pluck('name', 'id');

        // Get companies from users table where type = 'company'
        $companies = User::where('type', 'company')
            ->where('is_active', 1)
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->get()
            ->pluck('name', 'id');

        // Get items from Items model for dropdown
        $items = \App\Models\Items::where('deleted_at', NULL)
            ->when($user->type != 'super admin', function ($query) use ($user) {
                return $query->where('created_by', $user->creatorId());
            })
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'description']);
        
        return view('enquiry.edit', compact('enquiry', 'salesmen', 'companies', 'items'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}



// In EnquiryController.php - FIXED convertToQuotation method
public function convertToQuotation($id)
{
    if(\Auth::user()->can('enquiry_edit'))
    {
        $enquiry = Enquiry::findOrFail($id);
        
        // Check if enquiry belongs to current user's company
        $user = \Auth::user();
        if ($user->type != 'super admin' && $enquiry->created_by != $user->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        
        // Get customer from enquiry's company
        $customer = \App\Models\User::where('id', $enquiry->company_id)->first();
        
        if (!$customer) {
            // If customer doesn't exist, create a new customer from enquiry data
            $customer = \App\Models\Customer::create([
                'name' => $enquiry->company_name,
                'email' => $enquiry->mail_id,
                'mobile' => $enquiry->phone_no,
                'contact_person' => $enquiry->kind_attn,
                'company_id' => $enquiry->company_id,
                'created_by' => \Auth::user()->creatorId(),
                'is_active' => 1
            ]);
        }
        
        // Get items from enquiry
        $items = json_decode($enquiry->items, true) ?? [];
        
        // Prepare items for quotation
        $quotationItems = [];
        foreach ($items as $index => $item) {
            // Safely extract values with null coalescing
            $description = $item['description'] ?? 'Item ' . ($index + 1);
            $quantity = $item['quantity'] ?? 1;
            $salesPrice = $item['sales_price'] ?? $item['purchase_price'] ?? 0;
            
            $quotationItems[] = [
                'item_id' => $description, // Using description as item name
                'description' => $description,
                'quantity' => $quantity,
                'unit_price' => $salesPrice,
                'total_amount' => $quantity * $salesPrice,
                'suitable_item' => $item['suitable_item'] ?? '',
                'purchase_price' => $item['purchase_price'] ?? 0,
                'sales_price' => $salesPrice
            ];
        }
        
        // Store enquiry data in session to pre-fill quotation form
        session([
            'converted_enquiry' => [
                'enquiry_id' => $enquiry->id,
                'enquiry_no' => $enquiry->serial_no,
                'customer_id' => $customer->id,
                'company_id' => $enquiry->company_id,
                'company_name' => $enquiry->company_name,
                'contact_person' => $enquiry->kind_attn,
                'mail_id' => $enquiry->mail_id,
                'phone_no' => $enquiry->phone_no,
                'remarks' => $enquiry->remarks,
                'items' => $quotationItems,
                'pending_remarks' => $enquiry->pending_remarks,
                'enquiry_date' => $enquiry->enquiry_date,
                'salesman_id' => $enquiry->salesman_id,
                'salesman_name' => $enquiry->salesman ? $enquiry->salesman->name : null,
                'total_quantity' => $enquiry->qty
            ]
        ]);
        
        // REMOVE THIS LINE: session()->forget('converted_enquiry'); 
        
        // Update enquiry status to indicate it's being converted
        $enquiry->update([
            'status' => 'converted_to_quotation',
            'converted_at' => now()
        ]);
        
        // Redirect to quotation create page
        return redirect()->route('quotation.create');
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}

public function update(Request $request, $id)
{
    if(\Auth::user()->can('enquiry_edit'))
    {
        $enquiry = Enquiry::findOrFail($id);
        $validator = \Validator::make($request->all(), [
            'status' => 'required|in:ready_for_quotation,ready_for_purchase,ignored',
            'pending_remarks' => 'nullable|string',
            'quotation_no' => 'nullable|string|max:255',
            'quotation_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.suitable_item' => 'nullable|string|max:255',
            'items.*.purchase_price' => 'nullable|numeric|min:0',
            'items.*.sales_price' => 'nullable|numeric|min:0',
        ]);
        
        // Custom validation for items
        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                if (!isset($item['description']) || empty(trim($item['description']))) {
                    $validator->errors()->add("items.$index.description", "Item $index: Description is required");
                }
                
                if (!isset($item['quantity']) || $item['quantity'] < 1) {
                    $validator->errors()->add("items.$index.quantity", "Item $index: Quantity must be at least 1");
                }
            }
        }
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Process items
        $items = [];
        $totalQty = 0;
        
        if ($request->has('items')) {
            foreach ($request->items as $index => $itemData) {
                // Skip if description is empty
                if (empty(trim($itemData['description']))) {
                    continue;
                }
                
                $itemQuantity = isset($itemData['quantity']) ? (int)$itemData['quantity'] : 1;
                $totalQty += $itemQuantity;
                
                $item = [
                    'description' => trim($itemData['description']),
                    'quantity' => $itemQuantity,
                    'suitable_item' => $itemData['suitable_item'] ?? null,
                    'purchase_price' => isset($itemData['purchase_price']) ? number_format((float)$itemData['purchase_price'], 2, '.', '') : '0.00',
                    'sales_price' => isset($itemData['sales_price']) ? number_format((float)$itemData['sales_price'], 2, '.', '') : '0.00',
                ];
                
                // Handle image upload for each item if needed
                if (isset($itemData['image']) && $itemData['image']->isValid()) {
                    $imageName = time() . '_' . $index . '_' . $itemData['image']->getClientOriginalName();
                    $itemData['image']->storeAs('enquiry_items', $imageName, 'public');
                    $item['image'] = $imageName;
                } elseif (isset($itemData['existing_image'])) {
                    $item['image'] = $itemData['existing_image'];
                }
                
                $items[] = $item;
            }
        }
        
        // If no valid items after processing
        if (empty($items)) {
            return redirect()->back()
                ->with('error', 'At least one item with description is required')
                ->withInput();
        }
        
        // Set timestamps based on status
        $updateData = [
            'items' => json_encode($items),
            'qty' => $totalQty,
            'status' => $request->status,
            'pending_remarks' => $request->pending_remarks, // FIXED: Changed from purchase_remarks to pending_remarks
            'updated_at' => now(),
        ];
        
        // Handle quotation data if status is ready_for_quotation
        if ($request->status === 'ready_for_quotation') {
            $updateData['quotation_no'] = $request->quotation_no;
            $updateData['quotation_date'] = $request->quotation_date;
            $updateData['quotation_date_time'] = now();
        } else {
            // Clear quotation data if status is changed from ready_for_quotation
            $updateData['quotation_no'] = null;
            $updateData['quotation_date'] = null;
            $updateData['quotation_date_time'] = null;
        }
        
        // Handle purchase data if status is ready_for_purchase
        if ($request->status === 'ready_for_purchase') {
            $updateData['purchase_date_time'] = now();
        }
        
        // Handle ignore status
        if ($request->status === 'ignored') {
            $updateData['ignored_at'] = now();
        }
        
        // Only update other fields if they exist in the request
        if ($request->has('company_id')) {
            $updateData['company_id'] = $request->company_id;
        }
        
        if ($request->has('enquiry_date')) {
            $updateData['enquiry_date'] = $request->enquiry_date;
        }
        
        if ($request->has('salesman_id')) {
            $updateData['salesman_id'] = $request->salesman_id;
        }
        
        if ($request->has('kind_attn')) {
            $updateData['kind_attn'] = $request->kind_attn;
        }
        
        if ($request->has('mail_id')) {
            $updateData['mail_id'] = $request->mail_id;
        }
        
        if ($request->has('phone_no')) {
            $updateData['phone_no'] = $request->phone_no;
        }
        
        if ($request->has('remarks')) {
            $updateData['remarks'] = $request->remarks;
        }
        
        $enquiry->update($updateData);
        
        return redirect()->route('enquiry.index')->with('success', __('Enquiry updated successfully.'));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
    public function destroy($id)
    {
        if(\Auth::user()->can('enquiry_delete'))
        {
            $enquiry = Enquiry::findOrFail($id);
            $enquiry->delete();
            
            return redirect()->route('enquiry.index')->with('success', __('Enquiry deleted successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // ADD THESE NEW METHODS FOR ASSIGN, ISSUED, POP

    public function assign(Request $request, $id)
    {
        if(\Auth::user()->can('enquiry_edit'))
        {
            $request->validate([
                'salesman_id' => 'required|exists:users,id',
                'assigned_date_time' => 'required|date',
            ]);
            
            $enquiry = Enquiry::findOrFail($id);
            
            $enquiry->update([
                'salesman_id' => $request->salesman_id,
                'assigned_date_time' => $request->assigned_date_time,
                'status' => 'assigned',
            ]);
            
            return redirect()->route('enquiry.index')->with('success', __('Enquiry assigned successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function complete($id)
    {
        if(\Auth::user()->can('enquiry_edit'))
        {
            $enquiry = Enquiry::findOrFail($id);
            
            // Only allow completion if status is not cancelled or already completed
            if (!in_array($enquiry->status, ['cancelled', 'completed'])) {
                $enquiry->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
                
                return redirect()->route('enquiry.index')->with('success', __('Enquiry marked as completed.'));
            }
            
            return redirect()->back()->with('error', __('Cannot mark this enquiry as completed.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function issued($id)
    {
        if(\Auth::user()->can('enquiry_edit'))
        {
            $enquiry = Enquiry::findOrFail($id);
            
            $enquiry->update([
                'issued_date' => now(),
            ]);
            
            return redirect()->back()->with('success', __('Enquiry marked as issued.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function pop($id)
    {
        if(\Auth::user()->can('enquiry_edit'))
        {
            $enquiry = Enquiry::findOrFail($id);
            
            $enquiry->update([
                'pop_date' => now(),
            ]);
            
            return redirect()->back()->with('success', __('POP date updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}