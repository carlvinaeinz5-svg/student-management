<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class LecturersController extends Controller
{
    public function index(): View
    {
        $search = trim((string) request()->query('search', ''));
        $lecturerQuery = User::role('Lecturer');

        if ($search !== '') {
            $lecturerQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
                $query->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        $lecturers = $lecturerQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('lecturers.index', [
            'lecturers' => $lecturers,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        $lecturer = new User();

        return view('lecturers.create', [
            'lecturer' => $lecturer,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Role::firstOrCreate(['name' => 'Lecturer', 'guard_name' => 'web']);
        $lecturer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $lecturer->assignRole('Lecturer');

        return redirect()->route('lecturers.index')->with('status', 'Lecturer created successfully.');
    }

    public function edit(User $lecturer): View
    {
        if (! $lecturer->hasRole('Lecturer')) {
            abort(404);
        }

        return view('lecturers.edit', [
            'lecturer' => $lecturer,
        ]);
    }

    public function update(Request $request, User $lecturer): RedirectResponse
    {
        if (! $lecturer->hasRole('Lecturer')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$lecturer->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $lecturer->name = $validated['name'];
        $lecturer->email = $validated['email'];
        if (! empty($validated['password'])) {
            $lecturer->password = Hash::make($validated['password']);
        }
        $lecturer->save();

        return redirect()->route('lecturers.index')->with('status', 'Lecturer updated successfully.');
    }

    public function destroy(User $lecturer): RedirectResponse
    {
        if (! $lecturer->hasRole('Lecturer')) {
            abort(404);
        }
        $lecturer->delete();

        return redirect()->route('lecturers.index')->with('status', 'Lecturer deleted. Courses assigned to them are now unassigned.');
    }
}
