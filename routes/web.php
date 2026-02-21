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

    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');

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

    Route::post('/teacher/lessons', function (\Illuminate\Http\Request $request) {
        $course = \App\Models\Course::find($request->course_id);
        abort_if(!$course || $course->instructor_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'action_type' => 'required|in:draft,publish',
        ]);

        $status = $validated['action_type'] === 'draft' ? 'draft' : 'published';

        $lesson = $course->lessons()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $status,
        ]);

        $message = $status === 'draft' 
            ? 'Lesson saved as draft successfully.'
            : 'Lesson published successfully.';

        return redirect("/teacher/course/{$course->id}/lessons")->with('success', $message);
    });

    Route::delete('/teacher/lessons/{lesson}', function (\App\Models\Lesson $lesson) {
        abort_if($lesson->course->instructor_id !== auth()->id(), 403);
        $courseId = $lesson->course_id;
        $lesson->delete();
        return redirect("/teacher/course/{$courseId}/lessons")->with('success', 'Lesson deleted successfully.');
    });

    Route::get('/teacher/course/{course}/lessons/{lesson}/edit', function (\App\Models\Course $course, \App\Models\Lesson $lesson) {
        abort_if($course->instructor_id !== auth()->id() || $lesson->course_id !== $course->id, 403);
        return view('teacher.lessons', compact('course', 'lesson'));
    })->name('teacher.lesson.edit');

    Route::put('/teacher/lessons/{lesson}', function (\Illuminate\Http\Request $request, \App\Models\Lesson $lesson) {
        abort_if($lesson->course->instructor_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'action_type' => 'required|in:draft,publish',
        ]);

        $status = $validated['action_type'] === 'draft' ? 'draft' : 'published';

        $lesson->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $status,
        ]);

        $message = $status === 'draft' 
            ? 'Lesson updated and saved as draft successfully.'
            : 'Lesson updated and published successfully.';

        return redirect("/teacher/course/{$lesson->course_id}/lessons")->with('success', $message);
    })->name('teacher.lessons.update');

    Route::get('/teacher/course/{course}/students', function (\App\Models\Course $course) {
        abort_if($course->instructor_id !== auth()->id(), 403);
        return view('teacher.roster', compact('course'));
    })->name('teacher.roster');

});

// Classroom for enrolled students
Route::get('/classroom/{course}', function (\App\Models\Course $course) {
    return view('classroom', compact('course'));
})->middleware('auth')->name('classroom');

// Student routes
Route::middleware(['auth','role:student'])->group(function () {

    Route::get('/my-courses', function () {
        return view('student.my-courses');
    })->name('student.my-courses');

    Route::get('/lessons', function () {
        return view('student.lessons');
    })->name('student.lessons');

});

Route::view('/profile', 'profile')->middleware('auth');

