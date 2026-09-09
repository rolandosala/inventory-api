<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Administrator',
                'description' => 'Full access to the entire ICT Inventory System.',
            ],
            [
                'name' => 'ICT Administrator',
                'description' => 'Manages ICT inventory, users, settings, and reports.',
            ],
            [
                'name' => 'ICT Staff',
                'description' => 'Manages ICT assets and inventory transactions.',
            ],
            [
                'name' => 'Inventory Custodian',
                'description' => 'Handles receiving, assignment, transfer, and return of assets.',
            ],
            [
                'name' => 'Technician',
                'description' => 'Handles technical support and asset maintenance records.',
            ],
            [
                'name' => 'Viewer',
                'description' => 'Read-only access to inventory and reports.',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}