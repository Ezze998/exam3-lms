<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingFeatured;
use App\Livewire\CourseCatalog;
use App\Livewire\CourseShow;
use App\Http\Controllers\AuthController;
use App\Livewire\TeacherDashboard;
use App\Livewire\TeacherLessonManager;
use App\Livewire\StudentDashboard;
use App\Livewire\TeacherLessonForm;

Route::get('/', fn() => view('welcome'));

Route::view('/catalog', 'catalog');

Route::get('/courses/{course}', function (\App\Models\Course $course) {
    return view('course-show', compact('course'));
})->name('course.show');


Route::view('/dashboard', 'dashboard')->middleware('auth');

// login & logout
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth','role:teacher'])->group(function () {

    Route::view('/teacher/dashboard', 'teacher.dashboard')
        ->name('teacher.dashboard');

    Route::get('/teacher/course/create', function () {
        return view('teacher.create');
    })->name('teacher.course.create');

    Route::get('/teacher/course/{course}/edit', function (\App\Models\Course $course) {
        abort_if($course->instructor_id !== auth()->id(), 403);
        return view('teacher.edit', compact('course'));
    })->name('teacher.course.edit');

    Route::get('/teacher/course/{course}/lessons', function ($course) {
        return view('teacher.lessons', compact('course'));
    })->name('teacher.lessons');

    Route::get('/teacher/course/{course}/students', function (\App\Models\Course $course) {
        abort_if($course->instructor_id !== auth()->id(), 403);
        return view('teacher.roster', compact('course'));
    })->name('teacher.roster');

});

// Classroom for enrolled students
Route::get('/classroom/{course}', function (\App\Models\Course $course) {
    return view('classroom', compact('course'));
})->middleware('auth')->name('classroom');

Route::view('/profile', 'profile')->middleware('auth');

