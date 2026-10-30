<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        // Get all courses and all students
        $allCourses = Course::all();
        $students = User::role('Student')->get(); // Requires Spatie package

        // Register each student to 2 random courses
        foreach ($students as $student) {
            $student->courses()->syncWithoutDetaching(
                $allCourses->random(2)->pluck('id')
            );
        }
    }
}