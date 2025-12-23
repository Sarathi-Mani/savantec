<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\LoginDetail;
use App\Models\NOC;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use App\Models\UserCompany;
use Auth;
use File;
use App\Models\Utility;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UserToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Spatie\Permission\Models\Role;



class UserController extends Controller
{

public function index()
{
    $user = \Auth::user();
    if(\Auth::user()->can('manage user'))
    {
        if(\Auth::user()->type == 'super admin')
        {
            $users = User::where('created_by', '=', $user->creatorId())
                        ->where('type', '=', 'company')
                        ->where('is_active',1)
                        ->orderByDesc('created_at')
                        ->get();
        }
        else
        {
            $users = User::where('created_by', '=', $user->creatorId())
                        ->where('type', '!=', 'client')
                        ->where('is_active',1)
                        ->orderByDesc('created_at')
                        ->get();
            
            // Also include users from your company
            if ($user->type == 'company' && !empty($user->company_id)) {
                $companyIds = json_decode($user->company_id, true);
                if (is_array($companyIds)) {
                    $companyUsers = User::whereIn('id', $companyIds)
                                        ->where('is_active', 1)
                                        ->orderByDesc('created_at')
                                        ->get();
                    
                    // Merge users
                    $users = $users->merge($companyUsers)->unique('id');
                }
            }
        }

        return view('user.index')->with('users', $users);
    }
    else
    {
        return redirect()->back();
    }
}
    
    public function create()
    {
        $customFields = CustomField::where('created_by', '=', auth()->user()->creatorId())
            ->where('module', '=', 'user')
            ->get();
            
        $user  = auth()->user();
        $roles = Role::where('created_by', '=', $user->creatorId())
            ->where('name','!=','client')
            ->get()->pluck('name', 'id');
            
        // Fetch companies from User model where type = 'company'
        $companies = User::where('type', 'company')
            ->where(function($query) use ($user) {
                $query->where('created_by', $user->creatorId())
                      ->orWhere('id', $user->creatorId());
            })
            ->pluck('name', 'id');
        
        if(auth()->user()->can('create user'))
        {
            return view('user.create', compact('roles', 'customFields', 'companies'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
   public function store(Request $request)
{
    if(!auth()->user()->can('create user'))
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    // Debug: Check what data is coming
    \Log::info('Create User Request Data:', $request->all());
    
    // Check if companies field is coming as array
    if ($request->has('companies')) {
        \Log::info('Companies field received as array:', $request->companies);
    }

    // Validation
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|exists:roles,id',
        'companies' => 'required|array|min:1',
        'companies.*' => 'exists:users,id',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        'mobile' => 'nullable|string|max:20',
    ], [
        'companies.required' => 'Please select at least one company.',
        'companies.min' => 'Please select at least one company.',
    ]);

    if ($validator->fails()) {
        \Log::error('Validation failed:', $validator->errors()->toArray());
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        DB::beginTransaction(); // Start transaction
        
        // Handle profile picture upload - store in 'avatar' column
        $avatarPath = null;
        
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $settings = Utility::getStorageSetting();
            
            if($settings['storage_setting'] == 'local') {
                $dir = 'app/public/uploads/avatar/';
            } else {
                $dir = 'uploads/avatar';
            }
            
            $path = Utility::upload_file($request, 'profile_picture', $fileName, $dir, []);
            
            if($path['flag'] == 1) {
                if($settings['storage_setting'] == 'local') {
                    $avatarPath = str_replace('app/public/', '', $path['url']);
                } else {
                    $avatarPath = $path['url'];
                }
            } else {
                \Log::error('File upload failed: ' . $path['msg']);
                return redirect()->back()->with('error', __($path['msg']));
            }
        }

        // Get role name
        $role = Role::find($request->role);
        if (!$role) {
            return redirect()->back()->with('error', __('Role not found.'));
        }
        
        // Store companies as JSON array in company_id column
        $companyIdsJson = json_encode($request->companies);
        
        // Create user - save to 'avatar' column only
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'type' => $role->name,
            'company_id' => $companyIdsJson, // Store as JSON array ['1','2','3']
            'created_by' => auth()->user()->creatorId(),
            'email_verified_at' => now(),
            'is_active' => 1,
            'delete_status' => 1,
            'lang' => 'en', // Add default language
            'mode' => 'light', // Add default mode
            'dark_mode' => 0, // Add default dark mode
            'storage_limit' => 0.00, // Add default storage limit
            'messenger_color' => '#2180f3', // Add default messenger color
            'active_status' => 0, // Add default active status
            'is_email_verified' => 0, // Add default email verification status
        ];
        
        // Save to avatar column (your table has 'avatar' not 'profile_picture')
        if ($avatarPath) {
            $userData['avatar'] = $avatarPath;
        }
        
        $user = User::create($userData);

        // Store companies in pivot table if it exists
        if (class_exists('App\Models\UserCompany') && $request->has('companies')) {
            foreach ($request->companies as $companyId) {
                UserCompany::create([
                    'user_id' => $user->id,
                    'company_id' => $companyId,
                    'created_by' => auth()->user()->creatorId(),
                ]);
            }
        }

        // Assign role
        $user->assignRole($role->name);

        // Save custom fields
        if ($request->has('customField')) {
            foreach ($request->input('customField') as $fieldId => $value) {
                if ($value !== null && !empty(trim($value))) {
                    // Check if CustomFieldValue model exists
                    if (class_exists('App\Models\CustomFieldValue')) {
                        CustomFieldValue::updateOrCreate([
                            'custom_field_id' => $fieldId,
                            'model_id' => $user->id,
                            'model_type' => User::class,
                        ], [
                            'value' => $value,
                            'created_by' => auth()->user()->creatorId(),
                        ]);
                    }
                }
            }
        }

        DB::commit(); // Commit transaction
        
        \Log::info('User created successfully:', [
            'user_id' => $user->id, 
            'email' => $user->email,
            'avatar' => $user->avatar,
            'company_id' => $user->company_id
        ]);
        
        return redirect()->route('users.index')
            ->with('success', __('User created successfully.'));
            
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback transaction on error
        \Log::error('Error creating user: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->with('error', __('Error creating user: ') . $e->getMessage());
    }
}
    public function show()
    {
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        if(\Auth::user()->can('delete user'))
        {
            $user = User::find($id);
            
            if($user)
            {
                // Check if user is trying to delete themselves
                if($user->id == \Auth::user()->id)
                {
                    return redirect()->route('users.index')->with('error', __('You cannot delete yourself.'));
                }

                // Update delete_status to 0 (soft delete)
                $user->delete_status = 0;
                $user->is_active = 0;
                $user->save();

                return redirect()->route('users.index')->with('success', __('User successfully deleted.'));
            }
            else
            {
                return redirect()->route('users.index')->with('error', __('User not found.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

public function edit($id)
{
    $authUser = \Auth::user();
    $roles = Role::where('created_by', '=', $authUser->creatorId())
                ->where('name','!=','client')
                ->get()
                ->pluck('name', 'id');
    
    if(\Auth::user()->can('edit user'))
    {
        $user = User::findOrFail($id);
        $user->customField = CustomField::getData($user, 'user');
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())
                                  ->where('module', '=', 'user')
                                  ->get();

        // Get the user's role ID correctly
        $userRole = null;
        if ($user->type) {
            // Get the role by name and get its ID
            $role = Role::where('name', $user->type)
                       ->where('created_by', $authUser->creatorId())
                       ->first();
            if ($role) {
                $userRole = $role->id; // Store the ID, not the name
            }
        }

        // Get avatar URL for display
        $avatarUrl = null;
        if (!empty($user->avatar)) {
            $avatarPath = $user->avatar;
            // Check if it's a URL
            if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                $avatarUrl = $avatarPath;
            } else {
                // Try different possible paths
                if (strpos($avatarPath, 'uploads/avatar/') === 0) {
                    $avatarUrl = asset('storage/' . $avatarPath);
                } elseif (strpos($avatarPath, 'avatar/') === 0) {
                    $avatarUrl = asset('storage/uploads/' . $avatarPath);
                } elseif (strpos($avatarPath, '/') === false) {
                    $avatarUrl = asset('storage/uploads/avatar/' . $avatarPath);
                } else {
                    // Remove any storage prefixes
                    $cleanPath = str_replace(['app/public/', 'storage/'], '', $avatarPath);
                    $avatarUrl = asset('storage/' . $cleanPath);
                }
            }
        }

        // Initialize variables
        $companies = collect();
        $userCompanies = [];

        // Get companies for ALL users who can edit
        $companies = User::where('type', 'company')
            ->where(function($query) use ($authUser) {
                $query->where('created_by', $authUser->creatorId())
                      ->orWhere('id', $authUser->creatorId());
            })
            ->pluck('name', 'id');

        // Get user's current companies
        if ($user->company_id) {
            $decoded = json_decode($user->company_id, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $userCompanies = $decoded;
            } else {
                $userCompanies = [$user->company_id];
            }
        }

        return view('user.edit', compact(
            'user', 
            'roles', 
            'customFields', 
            'companies', 
            'userCompanies',
            'userRole',
            'avatarUrl' // Pass the avatar URL to view
        ));
    }
    else
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
public function update(Request $request, $id)
{
    if(!\Auth::user()->can('edit user'))
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    $user = User::findOrFail($id);
    $authUser = \Auth::user();
    
    // Create validator rules based on user type
    $validatorRules = [
        'first_name' => 'required|max:120',
        'last_name' => 'required|max:120',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|exists:roles,id',
        'mobile' => 'nullable|string|max:20',
    ];

    // Add companies validation only for super admin
    if ($authUser->type == 'super admin') {
        $validatorRules['companies'] = 'required|array|min:1';
        $validatorRules['companies.*'] = 'exists:users,id';
    }

    $validator = Validator::make($request->all(), $validatorRules, [
        'companies.required' => 'Please select at least one company.',
        'companies.min' => 'Please select at least one company.',
    ]);
        
    if($validator->fails())
    {
        \Log::error('Update validation failed:', $validator->errors()->toArray());
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        DB::beginTransaction();
        
        // Handle profile picture update - SAVE TO 'avatar' COLUMN ONLY
        if ($request->hasFile('profile_picture')) {
            \Log::info('Profile picture file detected');
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $settings = Utility::getStorageSetting();
            
            if($settings['storage_setting'] == 'local') {
                $dir = 'app/public/uploads/avatar/';
            } else {
                $dir = 'uploads/avatar';
            }
            
            // Delete old avatar if exists
            $oldAvatar = $user->avatar;
            
            if (!empty($oldAvatar) && !filter_var($oldAvatar, FILTER_VALIDATE_URL)) {
                if($settings['storage_setting'] == 'local') {
                    $oldAvatarPath = str_replace('storage/', '', $oldAvatar);
                    if (Storage::disk('public')->exists($oldAvatarPath)) {
                        Storage::disk('public')->delete($oldAvatarPath);
                        \Log::info('Deleted old avatar: ' . $oldAvatarPath);
                    }
                } else {
                    if (Storage::exists($oldAvatar)) {
                        Storage::delete($oldAvatar);
                        \Log::info('Deleted old avatar: ' . $oldAvatar);
                    }
                }
            }
            
            $path = Utility::upload_file($request, 'profile_picture', $fileName, $dir, []);
            
            if($path['flag'] == 1) {
                if($settings['storage_setting'] == 'local') {
                    $avatarPath = str_replace('app/public/', '', $path['url']);
                } else {
                    $avatarPath = $path['url'];
                }
                
                // Save the path to avatar column only
                $user->avatar = $avatarPath;
                
                \Log::info('Avatar updated:', [
                    'user_id' => $user->id,
                    'avatar_path' => $user->avatar,
                    'storage_setting' => $settings['storage_setting']
                ]);
            } else {
                \Log::error('File upload failed in update: ' . $path['msg']);
                return redirect()->back()->with('error', __($path['msg']));
            }
        }

        // Get role name
        $role = Role::find($request->role);
        if (!$role) {
            return redirect()->back()->with('error', __('Role not found.'));
        }

        \Log::info('Updating user:', [
            'user_id' => $user->id,
            'new_email' => $request->email,
            'new_role' => $role->name,
            'request_companies' => $request->has('companies') ? $request->companies : 'no companies'
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->type = $role->name;
        
        // Store companies as JSON array in company_id column (only for super admin)
        if($authUser->type == 'super admin' && $request->has('companies')) {
            $user->company_id = json_encode($request->companies);
            \Log::info('Updated company_id:', ['company_id' => $user->company_id]);
        }
        
        // Handle password update if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Update companies in pivot table if needed (only for super admin)
        if ($authUser->type == 'super admin' && $request->has('companies') && class_exists('App\Models\UserCompany')) {
            UserCompany::where('user_id', $user->id)->delete();
            
            foreach ($request->companies as $companyId) {
                UserCompany::create([
                    'user_id' => $user->id,
                    'company_id' => $companyId,
                    'created_by' => auth()->user()->creatorId(),
                ]);
            }
        }

        // Update role - remove all roles first, then assign new one
        $user->roles()->detach();
        $user->assignRole($role->name);

        // Save custom fields
        if ($request->has('customField')) {
            \Log::info('Saving custom fields');
            CustomField::saveData($user, $request->customField);
        }

        DB::commit();
        
        \Log::info('User updated successfully:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'type' => $user->type,
            'company_id' => $user->company_id
        ]);
        
        return redirect()->route('users.index')->with('success', __('User successfully updated.'));
        
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error updating user: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->with('error', __('Error updating user: ') . $e->getMessage());
    }
}

public function export(Request $request)
{
    if (!\Auth::user()->can('manage user')) {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    $user = \Auth::user();
    $fileName = 'users_' . date('Y_m_d_H_i_s') . '.xlsx';
    
    if (\Auth::user()->type == 'super admin') {
        $users = User::where('created_by', '=', $user->creatorId())
            ->where('type', '=', 'company')
            ->where('is_active', 1)
            ->get();
    } else {
        $users = User::where('created_by', '=', $user->creatorId())
            ->where('type', '!=', 'client')
            ->where('is_active', 1)
            ->get();
    }
    
    // For CSV/Excel export
    if ($request->format == 'csv' || $request->format == 'excel') {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Headers
            fputcsv($file, [
                'Name', 'Email', 'Type', 'Last Login', 'Status', 
                \Auth::user()->type == 'super admin' ? 'Plan' : '',
                \Auth::user()->type == 'super admin' ? 'Plan Expired' : '',
                'Created At'
            ]);
            
            // Data
            foreach ($users as $user) {
                $row = [
                    $user->name,
                    $user->email,
                    ucfirst($user->type),
                    $user->last_login_at ?: 'Never',
                    $user->delete_status == 0 ? 'Inactive' : 'Active',
                ];
                
                if (\Auth::user()->type == 'super admin') {
                    $row[] = !empty($user->currentPlan) ? $user->currentPlan->name : '';
                    $row[] = !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime');
                }
                
                $row[] = $user->created_at->format('Y-m-d H:i:s');
                
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    return redirect()->back()->with('error', __('Invalid export format.'));
}

public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                    ]
        );
        if($request->hasFile('profile'))
        {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $settings = Utility::getStorageSetting();
            if($settings['storage_setting']=='local')
            {
                $dir        = 'app/public/uploads/avatar/';
            }
            else{
                $dir        = 'uploads/avatar';
            }

            $image_path = $dir . $userDetail['avatar'];

            if(File::exists($image_path))
            {
                File::delete($image_path);
            }


            $url = '';
            $path = Utility::upload_file($request,'profile',$fileNameToStore,$dir,[]);
            if($path['flag'] == 1)
            {
                $url = $path['url'];
                // For local storage, save the relative path from public storage
                if($settings['storage_setting']=='local')
                {
                    // Remove 'app/public/' prefix if present, as Storage::url() expects path relative to public disk
                    $avatarPath = str_replace('app/public/', '', $path['url']);
                    $user['avatar'] = $avatarPath;
                }
                else
                {
                    $user['avatar'] = $path['url'];
                }
            }else{
                return redirect()->route('profile', \Auth::user()->id)->with('error', __($path['msg']));
            }

//            $dir        = storage_path('uploads/avatar/');
//            $image_path = $dir . $userDetail['avatar'];
//
//            if(File::exists($image_path))
//            {
//                File::delete($image_path);
//            }
//
//            if(!file_exists($dir))
//            {
//                mkdir($dir, 0777, true);
//            }
//            $path = $request->file('profile')->storeAs('uploads/avatar/', $fileNameToStore);

        }

        if(!empty($request->profile) && empty($user['avatar']))
        {
            $user['avatar'] = 'uploads/avatar/' . $fileNameToStore;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();
        CustomField::saveData($user, $request->customField);

        return redirect()->route('dashboard')->with(
            'success', 'Profile successfully updated.'
        );
    }

    public function updatePassword(Request $request)
    {

        if(Auth::Check())
        {
            $request->validate(
                [
                    'old_password' => 'required',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );
            $objUser          = Auth::user();
            $request_data     = $request->All();
            $current_password = $objUser->password;
            if(Hash::check($request_data['old_password'], $current_password))
            {
                $user_id            = Auth::User()->id;
                $obj_user           = User::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);;
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            }
            else
            {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        }
        else
        {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }
    // User To do module
  public function todo_store(Request $request)
  {
      $request->validate(
          ['title' => 'required|max:120']
      );

      $post            = $request->all();
      $post['user_id'] = Auth::user()->id;
      $todo            = UserToDo::create($post);


      $todo->updateUrl = route(
          'todo.update', [
                           $todo->id,
                       ]
      );
      $todo->deleteUrl = route(
          'todo.destroy', [
                            $todo->id,
                        ]
      );

      return $todo->toJson();
  }

  public function todo_update($todo_id)
  {
      $user_todo = UserToDo::find($todo_id);
      if($user_todo->is_complete == 0)
      {
          $user_todo->is_complete = 1;
      }
      else
      {
          $user_todo->is_complete = 0;
      }
      $user_todo->save();
      return $user_todo->toJson();
  }

  public function todo_destroy($id)
  {
      $todo = UserToDo::find($id);
      $todo->delete();

      return true;
  }

  // change mode 'dark or light'
  public function changeMode()
  {
      $usr = \Auth::user();
      if($usr->mode == 'light')
      {
          $usr->mode      = 'dark';
          $usr->dark_mode = 1;
      }
      else
      {
          $usr->mode      = 'light';
          $usr->dark_mode = 0;
      }
      $usr->save();

      return redirect()->back();
  }

  public function upgradePlan($user_id)
    {
        $user = User::find($user_id);
        $plans = Plan::get();
        return view('user.plan', compact('user', 'plans'));
    }
    public function activePlan($user_id, $plan_id)
    {

        $user       = User::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan       = Plan::find($plan_id);
        if($assignPlan['is_success'] == true && !empty($plan))
        {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => isset(\Auth::user()->planPrice()['currency']) ? \Auth::user()->planPrice()['currency'] : '',
                    'txn_id' => '',
                    'payment_status' => 'success',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );

            return redirect()->back()->with('success', 'Plan successfully upgraded.');
        }
        else
        {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }

    }

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);

        return view('user.reset', compact('user'));

    }

    public function userPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('user.index')->with(
            'success', 'User Password successfully updated.'
        );


    }


    //start for user login details
    public function userLog(Request $request)
    {
        $filteruser = User::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $filteruser->prepend('Select User', '');

        $query = DB::table('login_details')
            ->join('users', 'login_details.user_id', '=', 'users.id')
            ->select(DB::raw('login_details.*, users.id as user_id , users.name as user_name , users.email as user_email ,users.type as user_type'))
            ->where(['login_details.created_by' => \Auth::user()->id]);

        if(!empty($request->month))
        {
            $query->whereMonth('date', date('m',strtotime($request->month)));
            $query->whereYear('date', date('Y',strtotime($request->month)));
        }else{
            $query->whereMonth('date', date('m'));
            $query->whereYear('date', date('Y'));
        }

        if(!empty($request->users))
        {
            $query->where('user_id', '=', $request->users);
        }
        $userdetails = $query->get();
        $last_login_details = LoginDetail::where('created_by', \Auth::user()->creatorId())->get();

        return view('user.userlog', compact( 'userdetails','last_login_details','filteruser'));
    }

    public function userLogView($id)
    {
        $users = LoginDetail::find($id);

        return view('user.userlogview', compact('users'));
    }

    public function userLogDestroy($id)
    {
        $users = LoginDetail::where('user_id', $id)->delete();
        return redirect()->back()->with('success', 'User successfully deleted.');
    }


    public function toggleStatus(User $user)
{
    if (!\Auth::user()->can('edit user')) {
        return response()->json([
            'success' => false,
            'message' => __('Permission denied.')
        ], 403);
    }

    try {
        // Toggle delete_status (0 = Inactive, 1 = Active)
        $user->delete_status = $user->delete_status == 0 ? 1 : 0;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => __('User status updated successfully.'),
            'new_status' => $user->delete_status
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => __('Error updating status: ') . $e->getMessage()
        ], 500);
    }
}

    //end for user login details


}
