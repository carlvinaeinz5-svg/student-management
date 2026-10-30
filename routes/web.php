<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;


// 1. Public Route (Welcome page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Breeze Dashboard Route (Requires login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Authenticated Routes (Your custom logic goes here)
Route::middleware(['auth'])->group(function () {
    
    // --- Profile Routes (Provided by Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Admin Routes ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('courses', CourseController::class);
    });

    // --- Lecturer Routes ---
    Route::middleware(['role:Lecturer'])->group(function () {
        Route::get('/my-courses', [CourseController::class, 'lecturerCourses'])->name('courses.my-courses');
    });

    // --- Student Routes ---
    Route::middleware(['role:Student'])->group(function () {
        Route::get('/available-courses', [CourseController::class, 'index'])->name('courses.available');
        Route::post('/register-course/{course}', [RegistrationController::class, 'store'])->name('courses.register');
    });
});

// 4. Breeze Authentication Routes (Login, Register, etc.)
require __DIR__.'/auth.php';