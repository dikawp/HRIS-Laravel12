<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Human Resources' => [
                ['name' => 'HR Manager', 'job_description' => 'Manage HR operations and policies.'],
                ['name' => 'Recruiter', 'job_description' => 'Handle employee recruitment process.'],
            ],
            'Finance' => [
                ['name' => 'Finance Manager', 'job_description' => 'Oversee financial planning and reporting.'],
                ['name' => 'Accountant', 'job_description' => 'Prepare and manage financial records.'],
            ],
            'IT Department' => [
                ['name' => 'IT Manager', 'job_description' => 'Lead IT team and infrastructure.'],
                ['name' => 'Software Developer', 'job_description' => 'Develop and maintain software systems.'],
                ['name' => 'System Administrator', 'job_description' => 'Manage servers and networks.'],
            ],
            'Marketing' => [
                ['name' => 'Marketing Manager', 'job_description' => 'Plan and execute marketing campaigns.'],
                ['name' => 'Content Creator', 'job_description' => 'Create marketing materials and digital content.'],
            ],
            'Operations' => [
                ['name' => 'Operations Manager', 'job_description' => 'Coordinate operational efficiency.'],
                ['name' => 'Logistics Officer', 'job_description' => 'Manage inventory and distribution.'],
            ],
        ];

        foreach ($positions as $deptName => $posList) {
            $department = Department::where('name', $deptName)->first();
            if ($department) {
                foreach ($posList as $pos) {
                    Position::create([
                        'department_id' => $department->id,
                        'name' => $pos['name'],
                        'job_description' => $pos['job_description'],
                    ]);
                }
            }
        }
    }
}
