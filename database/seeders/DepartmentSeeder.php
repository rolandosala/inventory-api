<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'code' => 'CISA',
                'name' => 'Campus Information Systems and Applications',
            ],
            [
                'code' => 'ADMIN',
                'name' => 'Administration',
            ],
            [
                'code' => 'ACCOUNTING',
                'name' => 'Accounting Office',
            ],
            [
                'code' => 'HR',
                'name' => 'Human Resource Management Office',
            ],
            [
                'code' => 'REGISTRAR',
                'name' => 'Registrar',
            ],
            [
                'code' => 'PROCUREMENT',
                'name' => 'Procurement Office',
            ],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->updateOrInsert(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}