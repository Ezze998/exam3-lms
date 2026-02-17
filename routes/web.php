<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingFeatured;
use App\Livewire\CourseCatalog;
use App\Livewire\CourseShow;
use App\Http\Controllers\AuthController;
use App\Livewire\TeacherDashboard;
use App\Livewire\TeacherLessonManager;
use App\Livewire\StudentDashboard;
use App\livewire\TeacherLessonForm;

Route::get('/', fn() => view('welcome'));

Route::view('/catalog', 'catalog');

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

    Route::view('/teacher/course/{course}/lessons', 'teacher.lessons')
        ->name('teacher.lessons');

});

Route::middleware(['auth','role:teacher'])->group(function () {

    Route::view(
        '/teacher/dashboard',
        'components.teacher-dashboard.teacher-dashboard'
    )->name('teacher.dashboard');

});



Route::view('/profile', 'profile')->middleware('auth');


Route::get('/courses/{course}', function ($course) {
    return view('course-show', compact('course'));
});


