<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin & Lecturer
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'], 
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        $admin->assignRole('Admin');

        $lecturer = User::firstOrCreate(
            ['email' => 'lecturer@test.com'], 
            ['name' => 'Dr. Smith', 'password' => bcrypt('password')]
        );
        $lecturer->assignRole('Lecturer');

        // 2. Seed 5 Students
        for ($i = 1; $i <= 5; $i++) {
            $student = User::firstOrCreate(
                ['email' => "student{$i}@test.com"],
                ['name' => "Student {$i}", 'password' => bcrypt('password')]
            );
            $student->assignRole('Student');
        }
    }
}