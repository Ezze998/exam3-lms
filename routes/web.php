<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingFeatured;
use App\Livewire\CourseCatalog;
use App\Livewire\CourseShow;

Route::get('/', fn() => view('welcome'));

Route::view('/catalog', 'catalog');

Route::view('/dashboard', 'dashboard')->middleware('auth');

Route::get('/courses/{course}', function ($course) {
    return view('course-show', compact('course'));
});

