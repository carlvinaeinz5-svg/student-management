<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Illuminate\View\View;

class CourseRegistrationReportController extends Controller
{
    public function __invoke(): View
    {
        $search = trim((string) request()->query('search', ''));
        $registrationQuery = Registration::with(['course.lecturer', 'student']);

        if ($search !== '') {
            $registrationQuery->where(function ($query) use ($search) {
                $query->whereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_code', 'like', '%'.$search.'%');
                    $courseQuery->orWhere('title', 'like', '%'.$search.'%');
                });

                $query->orWhereHas('student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', '%'.$search.'%');
                    $studentQuery->orWhere('email', 'like', '%'.$search.'%');
                });

                $query->orWhereHas('course.lecturer', function ($lecturerQuery) use ($search) {
                    $lecturerQuery->where('name', 'like', '%'.$search.'%');
                });
            });
        }

        $registrations = $registrationQuery
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'Registrations' => Registration::count(),
            'Students' => User::role('Student')->count(),
            'Courses' => Course::count(),
        ];

        return view('reports.course-registrations', [
            'registrations' => $registrations,
            'summary' => $summary,
            'search' => $search,
        ]);
    }
}
