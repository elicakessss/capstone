<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'School of Information Technology and Engineering',
                'code' => 'SITE',
                'description' => 'Department for computer science and IT programs',
                'is_active' => true,
            ],
            [
                'name' => 'School of Nursing and Allied Health Sciences',
                'code' => 'SNAHS',
                'description' => 'Department for business and management programs',
                'is_active' => true,
            ],
            [
                'name' => 'School of Arts Sciences and Teacher Education',
                'code' => 'SASTE',
                'description' => 'Department for liberal arts and humanities programs',
                'is_active' => true,
            ],
            [
                'name' => 'School of Business, Accountancy, and Hospitality Management',
                'code' => 'SBAHM',
                'description' => 'Department for education and teaching programs',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}
