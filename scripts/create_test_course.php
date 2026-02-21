<?php
// Boot Laravel and create a test course (run: php scripts/create_test_course.php)
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;
use App\Models\User;

$teacher = User::where('role', 'teacher')->first();
if (! $teacher) {
    echo "No teacher user found.\n";
    exit(1);
}

try {
    $course = Course::create([
        'title' => 'Scripted Test Course ' . date('H:i:s'),
        'slug' => \Illuminate\Support\Str::slug('Scripted Test Course ' . date('H:i:s')),
        'description' => 'Created by automated test script.',
        'thumbnail' => null,
        'instructor_id' => $teacher->id,
    ]);
    echo "Created course id={$course->id} title={$course->title}\n";
    exit(0);
} catch (\Exception $e) {
    echo "Failed to create course: " . $e->getMessage() . "\n";
    exit(2);
}
