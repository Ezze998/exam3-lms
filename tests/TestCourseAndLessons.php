<?php
/**
 * TEST SCRIPT: Database Connections & Course Saving
 * Run: php artisan tinker < tests/TestCourseAndLessons.php
 * OR: php tests/TestCourseAndLessons.php
 */

// Test 1: Check Users
echo "=== TEST 1: Users ===\n";
$users = \App\Models\User::all();
echo "Total Users: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "  - {$user->id}: {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

// Test 2: Check Courses
echo "\n=== TEST 2: Courses ===\n";
$courses = \App\Models\Course::all();
echo "Total Courses: " . $courses->count() . "\n";
foreach ($courses as $course) {
    echo "  - {$course->id}: {$course->title} - Instructor: {$course->instructor->name}\n";
    echo "    - Lessons: {$course->lessons()->count()}\n";
    echo "    - Students: {$course->students()->count()}\n";
}

// Test 3: Check Lessons
echo "\n=== TEST 3: Lessons ===\n";
$lessons = \App\Models\Lesson::all();
echo "Total Lessons: " . $lessons->count() . "\n";
$publishedCount = $lessons->where('status', 'published')->count();
$draftCount = $lessons->where('status', 'draft')->count();
echo "Published: $publishedCount, Draft: $draftCount\n";

// Test 4: Check Enrollments
echo "\n=== TEST 4: Enrollments ===\n";
$enrollments = DB::table('enrollments')->count();
echo "Total Enrollments: $enrollments\n";

// Test 5: Check Lesson Completions
echo "\n=== TEST 5: Lesson Completions ===\n";
$completions = DB::table('lesson_user')->count();
echo "Total Completions: $completions\n";

// Test 6: Student Course Relationships
echo "\n=== TEST 6: Student Relationships ===\n";
$student = \App\Models\User::where('role', 'student')->first();
if ($student) {
    echo "Student: {$student->name}\n";
    echo "  - Enrolled Courses: {$student->courses()->count()}\n";
    echo "  - Completed Lessons: {$student->completedLessons()->count()}\n";
    echo "\n  Courses:\n";
    foreach ($student->courses as $course) {
        echo "    - {$course->title}\n";
    }
}

// Test 7: Teacher Dashboard Data
echo "\n=== TEST 7: Teacher Dashboard ===\n";
$teacher = \App\Models\User::where('role', 'teacher')->first();
if ($teacher) {
    echo "Teacher: {$teacher->name}\n";
    echo "  - Teaching Courses: {$teacher->teachingCourses()->count()}\n";
    $totalStudents = $teacher->teachingCourses()->with('students')->get()->sum(function($c) {
        return $c->students()->count();
    });
    echo "  - Total Students: $totalStudents\n";
}

// Test 8: Create New Course (Simulate CourseForm::save())
echo "\n=== TEST 8: Create New Course ===\n";
try {
    $newCourse = \App\Models\Course::create([
        'title' => 'Test Course - ' . date('H:i:s'),
        'description' => 'This is a test course created at ' . now(),
        'thumbnail_url' => null,
        'instructor_id' => $teacher->id ?? 1,
    ]);
    echo "✓ Course created successfully!\n";
    echo "  ID: {$newCourse->id}\n";
    echo "  Title: {$newCourse->title}\n";
    echo "  Instructor: {$newCourse->instructor->name}\n";
} catch (\Exception $e) {
    echo "✗ Failed to create course: " . $e->getMessage() . "\n";
}

// Test 9: Verify StudentCourses Component Query
echo "\n=== TEST 9: StudentCourses Component Query ===\n";
$studentForCourses = \App\Models\User::where('role', 'student')->first();
if ($studentForCourses) {
    echo "Testing StudentCourses query for: {$studentForCourses->name}\n";
    $courses = $studentForCourses->courses()
        ->withCount('lessons')
        ->paginate(12);
    echo "  - Found " . $courses->count() . " courses\n";
    foreach ($courses as $course) {
        echo "    - {$course->title} ({$course->lessons_count} lessons)\n";
    }
}

// Test 10: Verify StudentLessons Component Query
echo "\n=== TEST 10: StudentLessons Component Query ===\n";
if ($studentForCourses) {
    echo "Testing StudentLessons query for: {$studentForCourses->name}\n";
    
    // New lessons
    $newLessons = \App\Models\Lesson::whereHas('course', function ($query) use ($studentForCourses) {
        $query->whereIn('id', $studentForCourses->courses()->pluck('courses.id'));
    })
    ->where('status', 'published')
    ->whereNotIn('id', $studentForCourses->completedLessons()->pluck('lessons.id'))
    ->get();
    echo "  - New Lessons: " . $newLessons->count() . "\n";
    
    // Completed lessons
    $completedLessons = $studentForCourses->completedLessons()
        ->where('status', 'published')
        ->get();
    echo "  - Completed Lessons: " . $completedLessons->count() . "\n";
}

echo "\n=== ALL TESTS COMPLETE ===\n";
