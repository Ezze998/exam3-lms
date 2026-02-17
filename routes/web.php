<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingFeatured;
use App\Livewire\CourseCatalog;
use App\Livewire\CourseShow;
use App\Http\Controllers\AuthController;

Route::get('/', fn() => view('welcome'));

Route::view('/catalog', 'catalog');

Route::view('/dashboard', 'dashboard')->middleware('auth');

// login & logout
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/teacher', function () {
    return "teacher only";
})->middleware(['auth','role:teacher']);


Route::view('/profile', 'profile')->middleware('auth');


Route::get('/courses/{course}', function ($course) {
    return view('course-show', compact('course'));
});

Route::middleware(['auth','role:teacher'])->group(function () {

    Route::get('/teacher/dashboard', Dashboard::class)
        ->name('teacher.dashboard');

});

