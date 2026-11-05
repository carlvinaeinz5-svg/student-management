<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request()->query('search', ''));
        $courseQuery = Course::with('lecturer');

        if ($search !== '') {
            $courseQuery->where(function ($query) use ($search) {
                $query->where('course_code', 'like', '%'.$search.'%');
                $query->orWhere('title', 'like', '%'.$search.'%');
                $query->orWhereHas('lecturer', function ($lecturerQuery) use ($search) {
                    $lecturerQuery->where('name', 'like', '%'.$search.'%');
                });
            });
        }

        $courses = $courseQuery
            ->orderBy('course_code')
            ->paginate(10)
            ->withQueryString();

        if (Auth::user()->hasRole('Student')) {
            $registeredCourseIds = Auth::user()->courses()->pluck('courses.id')->all();

            return view('courses.available', [
                'courses' => $courses,
                'registeredCourseIds' => $registeredCourseIds,
                'search' => $search,
            ]);
        }

        return view('courses.index', [
            'courses' => $courses,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        // An empty course gives the form blank values when adding a course.
        $course = new Course();
        $lecturers = User::role('Lecturer')->orderBy('name')->get();

        return view('courses.create', [
            'course' => $course,
            'lecturers' => $lecturers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:255', 'unique:courses,course_code'],
            'title' => ['required', 'string', 'max:255'],
            'lecturer_id' => ['nullable', Rule::in(User::role('Lecturer')->pluck('id')->all())],
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('status', 'Course created successfully.');
    }

    public function show(Course $course): View
    {
        $course->load([
            'lecturer',
            'students' => function ($query) {
                $query->orderBy('name');
            },
        ]);

        return view('courses.show', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course): View
    {
        $lecturers = User::role('Lecturer')->orderBy('name')->get();

        return view('courses.edit', [
            'course' => $course,
            'lecturers' => $lecturers,
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'course_code' => ['required', 'string', 'max:255', 'unique:courses,course_code,'.$course->id],
            'title' => ['required', 'string', 'max:255'],
            'lecturer_id' => ['nullable', Rule::in(User::role('Lecturer')->pluck('id')->all())],
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('status', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('status', 'Course deleted successfully.');
    }

    public function lecturerCourses(): View
    {
        $courses = Course::withCount('students')
            ->where('lecturer_id', Auth::id())
            ->orderBy('course_code')
            ->paginate(10);

        return view('courses.lecturer', [
            'courses' => $courses,
        ]);
    }

    public function myRegistrations(): View
    {
        $courses = Auth::user()->courses()
            ->with('lecturer')
            ->orderBy('course_code')
            ->paginate(10);

        return view('courses.registered', [
            'courses' => $courses,
        ]);
    }

    public function lecturerCourse(Course $course): View
    {
        if ($course->lecturer_id !== Auth::id()) {
            abort(404);
        }

        $course->load([
            'students' => function ($query) {
                $query->orderBy('name');
            },
        ]);

        return view('courses.lecturer-show', [
            'course' => $course,
        ]);
    }
}
