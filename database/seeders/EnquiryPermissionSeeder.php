<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EnquiryPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions for enquiry
        $permissions = [
            'manage enquiry',
            'create enquiry',
            'edit enquiry',
            'delete enquiry',
            'view enquiry'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superAdmin = Role::where('name', 'super admin')->first();
        $company = Role::where('name', 'company')->first();
        $hr = Role::where('name', 'HR')->first();
        $salesEngineer = Role::where('name', 'Sales Engineer')->first();

        if ($superAdmin) {
            $superAdmin->givePermissionTo($permissions);
        }

        if ($company) {
            $company->givePermissionTo($permissions);
        }

        if ($hr) {
            $hr->givePermissionTo($permissions);
        }

        // Sales Engineer can only view enquiries
        if ($salesEngineer) {
            $salesEngineer->givePermissionTo(['view enquiry']);
        }
    }
}