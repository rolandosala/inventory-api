<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            ['name' => 'dashboard.view', 'description' => 'View dashboard'],

            // Assets
            ['name' => 'assets.view', 'description' => 'View ICT assets'],
            ['name' => 'assets.create', 'description' => 'Create ICT assets'],
            ['name' => 'assets.update', 'description' => 'Update ICT assets'],
            ['name' => 'assets.delete', 'description' => 'Delete ICT assets'],
            ['name' => 'assets.assign', 'description' => 'Assign ICT assets'],
            ['name' => 'assets.return', 'description' => 'Return ICT assets'],
            ['name' => 'assets.transfer', 'description' => 'Transfer ICT assets'],
            ['name' => 'assets.dispose', 'description' => 'Dispose ICT assets'],

            // Categories
            ['name' => 'categories.view', 'description' => 'View categories'],
            ['name' => 'categories.create', 'description' => 'Create categories'],
            ['name' => 'categories.update', 'description' => 'Update categories'],
            ['name' => 'categories.delete', 'description' => 'Delete categories'],

            // Departments
            ['name' => 'departments.view', 'description' => 'View departments'],
            ['name' => 'departments.create', 'description' => 'Create departments'],
            ['name' => 'departments.update', 'description' => 'Update departments'],
            ['name' => 'departments.delete', 'description' => 'Delete departments'],

            // Locations
            ['name' => 'locations.view', 'description' => 'View locations'],
            ['name' => 'locations.create', 'description' => 'Create locations'],
            ['name' => 'locations.update', 'description' => 'Update locations'],
            ['name' => 'locations.delete', 'description' => 'Delete locations'],

            // Suppliers
            ['name' => 'suppliers.view', 'description' => 'View suppliers'],
            ['name' => 'suppliers.create', 'description' => 'Create suppliers'],
            ['name' => 'suppliers.update', 'description' => 'Update suppliers'],
            ['name' => 'suppliers.delete', 'description' => 'Delete suppliers'],

            // Maintenance
            ['name' => 'maintenance.view', 'description' => 'View maintenance records'],
            ['name' => 'maintenance.create', 'description' => 'Create maintenance records'],
            ['name' => 'maintenance.update', 'description' => 'Update maintenance records'],
            ['name' => 'maintenance.delete', 'description' => 'Delete maintenance records'],

            // Inventory transactions
            ['name' => 'inventory.view', 'description' => 'View inventory transactions'],
            ['name' => 'inventory.receive', 'description' => 'Receive inventory'],
            ['name' => 'inventory.transfer', 'description' => 'Transfer inventory'],
            ['name' => 'inventory.adjust', 'description' => 'Adjust inventory'],

            // Reports
            ['name' => 'reports.view', 'description' => 'View reports'],
            ['name' => 'reports.export', 'description' => 'Export reports'],

            // Users
            ['name' => 'users.view', 'description' => 'View users'],
            ['name' => 'users.create', 'description' => 'Create users'],
            ['name' => 'users.update', 'description' => 'Update users'],
            ['name' => 'users.delete', 'description' => 'Delete users'],

            // Roles
            ['name' => 'roles.view', 'description' => 'View roles'],
            ['name' => 'roles.create', 'description' => 'Create roles'],
            ['name' => 'roles.update', 'description' => 'Update roles'],
            ['name' => 'roles.delete', 'description' => 'Delete roles'],

            // Permissions
            ['name' => 'permissions.view', 'description' => 'View permissions'],
            ['name' => 'permissions.manage', 'description' => 'Manage permissions'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                [
                    'description' => $permission['description'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}