<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request()->query('search', ''));
        $studentQuery = User::role('Student');

        if ($search !== '') {
            $studentQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
                $query->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        $students = $studentQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', [
            'students' => $students,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        $student = new User();

        return view('students.create', [
            'student' => $student,
        ]);
    }

    public function show(User $student): View
    {
        if (! $student->hasRole('Student')) {
            abort(404);
        }
        $student->load(['courses.lecturer']);

        return view('students.show', [
            'student' => $student,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $student = User::create($validated);
        $student->assignRole('Student');

        return redirect()->route('students.index')->with('status', 'Student created successfully.');
    }

    public function edit(User $student): View
    {
        if (! $student->hasRole('Student')) {
            abort(404);
        }

        return view('students.edit', [
            'student' => $student,
        ]);
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        if (! $student->hasRole('Student')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$student->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('status', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        if (! $student->hasRole('Student')) {
            abort(404);
        }
        $student->delete();

        return redirect()->route('students.index')->with('status', 'Student deleted successfully.');
    }
}
