<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $summary = [
                'Students' => User::role('Student')->count(),
                'Lecturers' => User::role('Lecturer')->count(),
                'Courses' => Course::count(),
            ];
        } elseif ($user->hasRole('Lecturer')) {
            $courses = Course::withCount('students')->where('lecturer_id', $user->id)->get();
            $summary = [
                'My courses' => $courses->count(),
                'Course registrations' => $courses->sum('students_count'),
            ];
        } else {
            $summary = [
                'My courses' => $user->courses()->count(),
                'Available courses' => Course::count(),
            ];
        }

        return view('dashboard', [
            'summary' => $summary,
        ]);
    }
}
