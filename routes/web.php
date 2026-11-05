<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseRegistrationReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LecturersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

// Open the login page when someone visits the home address.
Route::get('/', function () {
    return redirect()->route('login');
});

// Show the dashboard after a user signs in.
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// These pages are available to any signed-in user.
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Only an Admin can manage students, lecturers, courses, and reports.
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/reports/course-registrations', CourseRegistrationReportController::class)
            ->name('reports.course-registrations');

        Route::get('/students', [StudentsController::class, 'index'])
            ->name('students.index');
        Route::get('/students/create', [StudentsController::class, 'create'])
            ->name('students.create');
        Route::post('/students', [StudentsController::class, 'store'])
            ->name('students.store');
        Route::get('/students/{student}', [StudentsController::class, 'show'])
            ->name('students.show');
        Route::get('/students/{student}/edit', [StudentsController::class, 'edit'])
            ->name('students.edit');
        Route::put('/students/{student}', [StudentsController::class, 'update'])
            ->name('students.update');
        Route::delete('/students/{student}', [StudentsController::class, 'destroy'])
            ->name('students.destroy');

        Route::get('/lecturers', [LecturersController::class, 'index'])
            ->name('lecturers.index');
        Route::get('/lecturers/create', [LecturersController::class, 'create'])
            ->name('lecturers.create');
        Route::post('/lecturers', [LecturersController::class, 'store'])
            ->name('lecturers.store');
        Route::get('/lecturers/{lecturer}/edit', [LecturersController::class, 'edit'])
            ->name('lecturers.edit');
        Route::put('/lecturers/{lecturer}', [LecturersController::class, 'update'])
            ->name('lecturers.update');
        Route::delete('/lecturers/{lecturer}', [LecturersController::class, 'destroy'])
            ->name('lecturers.destroy');

        Route::get('/courses', [CourseController::class, 'index'])
            ->name('courses.index');
        Route::get('/courses/create', [CourseController::class, 'create'])
            ->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])
            ->name('courses.store');
        Route::get('/courses/{course}', [CourseController::class, 'show'])
            ->name('courses.show');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])
            ->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])
            ->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])
            ->name('courses.destroy');
    });

    // Lecturers can see their courses and the students in those courses.
    Route::middleware(['role:Lecturer'])->group(function () {
        Route::get('/my-courses', [CourseController::class, 'lecturerCourses'])
            ->name('courses.my-courses');
        Route::get('/my-courses/{course}', [CourseController::class, 'lecturerCourse'])
            ->name('courses.my-courses.show');
    });

    // Students can browse, register for, and drop courses.
    Route::middleware(['role:Student'])->group(function () {
        Route::get('/available-courses', [CourseController::class, 'index'])
            ->name('courses.available');
        Route::get('/my-registrations', [CourseController::class, 'myRegistrations'])
            ->name('courses.registered');
        Route::post('/register-course/{course}', [RegistrationController::class, 'store'])
            ->name('courses.register');
        Route::delete('/my-registrations/{course}', [RegistrationController::class, 'destroy'])
            ->name('courses.unregister');
    });
});

// Add the login, logout, password reset, and registration routes.
require __DIR__.'/auth.php';
