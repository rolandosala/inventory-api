<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = DB::table('permissions')
            ->pluck('id', 'name');

        $roles = DB::table('roles')
            ->pluck('id', 'name');

        /*
        |--------------------------------------------------------------------------
        | Super Administrator
        |--------------------------------------------------------------------------
        */

        $superAdminPermissions = $permissions->values();

        foreach ($superAdminPermissions as $permissionId) {
            DB::table('permission_role')->updateOrInsert([
                'role_id' => $roles['Super Administrator'],
                'permission_id' => $permissionId,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ICT Administrator
        |--------------------------------------------------------------------------
        */

        $ictAdminPermissions = [
            'dashboard.view',

            'assets.view',
            'assets.create',
            'assets.update',
            'assets.delete',
            'assets.assign',
            'assets.return',
            'assets.transfer',
            'assets.dispose',

            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            'locations.view',
            'locations.create',
            'locations.update',
            'locations.delete',

            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',

            'maintenance.view',
            'maintenance.create',
            'maintenance.update',
            'maintenance.delete',

            'inventory.view',
            'inventory.receive',
            'inventory.transfer',
            'inventory.adjust',

            'reports.view',
            'reports.export',

            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            'permissions.view',
            'permissions.manage',
        ];

        $this->assignPermissions(
            $roles['ICT Administrator'],
            $ictAdminPermissions,
            $permissions
        );

        /*
        |--------------------------------------------------------------------------
        | ICT Staff
        |--------------------------------------------------------------------------
        */

        $ictStaffPermissions = [
            'dashboard.view',

            'assets.view',
            'assets.create',
            'assets.update',
            'assets.assign',
            'assets.return',
            'assets.transfer',

            'categories.view',
            'departments.view',
            'locations.view',
            'suppliers.view',

            'maintenance.view',
            'maintenance.create',
            'maintenance.update',

            'inventory.view',
            'inventory.receive',
            'inventory.transfer',

            'reports.view',
            'reports.export',
        ];

        $this->assignPermissions(
            $roles['ICT Staff'],
            $ictStaffPermissions,
            $permissions
        );

        /*
        |--------------------------------------------------------------------------
        | Inventory Custodian
        |--------------------------------------------------------------------------
        */

        $custodianPermissions = [
            'dashboard.view',

            'assets.view',
            'assets.assign',
            'assets.return',
            'assets.transfer',

            'categories.view',
            'departments.view',
            'locations.view',
            'suppliers.view',

            'inventory.view',
            'inventory.receive',
            'inventory.transfer',

            'reports.view',
            'reports.export',
        ];

        $this->assignPermissions(
            $roles['Inventory Custodian'],
            $custodianPermissions,
            $permissions
        );

        /*
        |--------------------------------------------------------------------------
        | Technician
        |--------------------------------------------------------------------------
        */

        $technicianPermissions = [
            'dashboard.view',

            'assets.view',

            'categories.view',
            'departments.view',
            'locations.view',

            'maintenance.view',
            'maintenance.create',
            'maintenance.update',

            'reports.view',
        ];

        $this->assignPermissions(
            $roles['Technician'],
            $technicianPermissions,
            $permissions
        );

        /*
        |--------------------------------------------------------------------------
        | Viewer
        |--------------------------------------------------------------------------
        */

        $viewerPermissions = [
            'dashboard.view',
            'assets.view',
            'categories.view',
            'departments.view',
            'locations.view',
            'suppliers.view',
            'maintenance.view',
            'inventory.view',
            'reports.view',
        ];

        $this->assignPermissions(
            $roles['Viewer'],
            $viewerPermissions,
            $permissions
        );
    }

    private function assignPermissions(
        int $roleId,
        array $permissionNames,
        $permissions
    ): void {
        foreach ($permissionNames as $permissionName) {

            if (!isset($permissions[$permissionName])) {
                continue;
            }

            DB::table('permission_role')->updateOrInsert(
                [
                    'role_id' => $roleId,
                    'permission_id' => $permissions[$permissionName],
                ]
            );
        }
    }
}