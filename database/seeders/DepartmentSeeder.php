<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Human Resources', 'description' => 'Responsible for recruitment and employee management.'],
            ['name' => 'Finance', 'description' => 'Handles company finances and budgeting.'],
            ['name' => 'IT Department', 'description' => 'Maintains information systems and infrastructure.'],
            ['name' => 'Marketing', 'description' => 'Develops and executes marketing strategies.'],
            ['name' => 'Operations', 'description' => 'Oversees daily operational activities.'],
        ];

        foreach ($departments as $data) {
            Department::create($data);
        }
    }
}
