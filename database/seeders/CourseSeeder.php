<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch the lecturer created in UserSeeder
        $lecturer = User::where('email', 'lecturer@test.com')->first();

        if ($lecturer) {
            $courses = [
                ['course_code' => 'CS101', 'title' => 'Intro to Programming', 'lecturer_id' => $lecturer->id],
                ['course_code' => 'CS102', 'title' => 'Data Structures', 'lecturer_id' => $lecturer->id],
                ['course_code' => 'WEB201', 'title' => 'Advanced Web Dev', 'lecturer_id' => $lecturer->id],
                ['course_code' => 'DB301', 'title' => 'Database Systems', 'lecturer_id' => $lecturer->id],
            ];
            
            foreach($courses as $course) {
                Course::firstOrCreate(['course_code' => $course['course_code']], $course);
            }
        }
    }
}