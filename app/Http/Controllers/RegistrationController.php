<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function store(Course $course): RedirectResponse
    {
        // The route only allows students to get here, so this is the signed-in student.
        $student = Auth::user();

        // Do not add the same student-course pair twice.
        if ($student->courses()->whereKey($course->id)->exists()) {
            return back()->with('status', 'You are already registered for that course.');
        }

        // Add a row to the registrations table connecting this student and course.
        $student->courses()->attach($course->id);

        return back()->with('status', 'Course registration successful.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $student = Auth::user();

        // Remove this student's link to the course from the registrations table.
        $removed = $student->courses()->detach($course->id);

        if ($removed === 0) {
            return back()->with('status', 'You were not registered for that course.');
        }

        return back()->with('status', 'You have dropped the course.');
    }
}
