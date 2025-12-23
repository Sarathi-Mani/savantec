<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RoleController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage role'))
        {

           $roles = Role::where('created_by', \Auth::user()->creatorId())->OrderBy('created_at','desc')->get();
            return view('role.index')->with('roles', $roles);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }


    public function create()
{
    if(\Auth::user()->can('create role'))
    {
        $user = \Auth::user();
        if($user->type == 'super admin')
        {
            $permissions = Permission::all()->pluck('name', 'id')->toArray();
        }
        else
        {
            $permissions = new Collection();
            foreach($user->roles as $role)
            {
                $permissions = $permissions->merge($role->permissions);
            }
            $permissions = $permissions->pluck('name', 'id')->toArray();
        }

        return view('role.create', ['permissions' => $permissions]);
    }
    else
    {
        return redirect()->back()->with('error', 'Permission denied.');
    }
}


  public function store(Request $request)
{
    if(\Auth::user()->can('create role'))
    {
        $validator = \Validator::make(
            $request->all(), [
                'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . \Auth::user()->creatorId(),
                'description' => 'nullable|string|max:500', // Add validation for description
                'permissions' => 'required',
            ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;
        $role->description = $request['description']; // Add this line
        $role->created_by = \Auth::user()->creatorId();
        $permissions = $request['permissions'];
        $role->save();

        // Create permissions if they don't exist
        foreach($permissions as $permissionName) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web'
            ]);
        }

        // Get permission IDs from names
        $permissionNames = Permission::whereIn('name', $permissions)
            ->pluck('name')
            ->toArray();
        
        // Sync permissions to role
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('success', 'Role ' . $role->name . ' created successfully!');
    }
    else
    {
        return redirect()->back()->with('error', 'Permission denied.');
    }
}
    public function edit(Role $role)
    {
        if(\Auth::user()->can('edit role'))
        {

            $user = \Auth::user();
            if($user->type == 'super admin')
            {
                $permissions = Permission::all()->pluck('name', 'id')->toArray();
            }
            else
            {
                $permissions = new Collection();
                foreach($user->roles as $role1)
                {
                    $permissions = $permissions->merge($role1->permissions);
                }
                $permissions = $permissions->pluck('name', 'id')->toArray();
            }

            return view('role.edit', compact('role', 'permissions'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }
public function update(Request $request, Role $role)
{
    if(\Auth::user()->can('edit role'))
    {
        $validator = \Validator::make(
            $request->all(), [
                'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId(),
                'permissions' => 'required',
            ]
        );
        
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        // Create permissions if they don't exist
        foreach($permissions as $permissionName) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web'
            ]);
        }

        // Get permission IDs from names
        $permissionNames = Permission::whereIn('name', $permissions)
            ->pluck('name')
            ->toArray();
        
        // Sync permissions to role
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('success', 'Role ' . $role->name . ' updated successfully!');
    }
    else
    {
        return redirect()->back()->with('error', 'Permission denied.');
    }
}
    public function destroy(Role $role)
    {
        if(\Auth::user()->can('delete role'))
        {
            $role->delete();

            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }


    public function exportCSV()
{
    $roles = Role::with('permissions')->get();

    $filename = "roles.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, ['ID', 'Role', 'Description', 'Permissions']);

    foreach ($roles as $role) {
        fputcsv($handle, [
            $role->id,
            $role->name,
            $role->description ?? 'N/A',
            $role->permissions->pluck('name')->implode(', ')
        ]);
    }

    fclose($handle);

    return response()->download($filename)->deleteFileAfterSend(true);
}



public function exportPDF()
{
    $roles = Role::with('permissions')->get();

$pdf = Pdf::loadView('role.pdf', compact('roles'))
                ->setPaper('a4', 'portrait');

    return $pdf->download('roles.pdf');
}


public function exportExcel()
{
    $roles = Role::with('permissions')->get();

    // For Excel, we can use CSV for now (browsers treat CSV as Excel)
    $filename = "roles.xlsx.csv";
    $handle = fopen($filename, 'w+');
    
    // Add UTF-8 BOM for Excel compatibility
    fwrite($handle, "\xEF\xBB\xBF");
    
    fputcsv($handle, ['ID', 'Role', 'Description', 'Permissions', 'Created At']);

    foreach ($roles as $role) {
        fputcsv($handle, [
            $role->id,
            $role->name,
            $role->description ?? 'N/A',
            $role->permissions->pluck('name')->implode(', '),
            $role->created_at->format('Y-m-d H:i:s')
        ]);
    }

    fclose($handle);

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="roles_export_' . date('Y-m-d') . '.csv"',
    ];

    return response()->download($filename)->deleteFileAfterSend(true);
}

public function printView()
{
    $roles = Role::with('permissions')->get();
    
    return view('role.print', compact('roles'));
}
}
