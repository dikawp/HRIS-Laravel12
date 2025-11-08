<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $departments = Department::all();
        $positions = Position::all();

        for ($i = 1; $i <= 12; $i++) {
            $department = $departments->random();
            $availablePositions = $positions->where('department_id', $department->id);
            $position = $availablePositions->isNotEmpty()
                ? $availablePositions->random()
                : $positions->random();

            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);

            Employee::create([
                'user_id'        => $user->id,
                'nik'            => strtoupper(substr($department->name, 0, 2)) . str_pad($i, 3, '0', STR_PAD_LEFT),
                'full_name'      => $user->name,
                'place_of_birth' => $faker->city(),
                'date_of_birth'  => $faker->dateTimeBetween('-40 years', '-22 years')->format('Y-m-d'),
                'gender'         => $faker->randomElement(['Male', 'Female']),
                'marital_status' => $faker->randomElement(['Single', 'Married']),
                'address'        => $faker->address(),
                'phone_number'   => '08' . $faker->numerify('##########'),
                'hire_date'      => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'position_id'    => $position->id,
                'department_id'  => $department->id,
                'photo'          => null,
            ]);
        }
    }
}
