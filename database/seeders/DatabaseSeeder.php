<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        // Teacher
        $teacher = User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Mr Instructor',
                'password' => Hash::make('password'),
                'role' => 'teacher'
            ]
        );

        // Students
        $students = collect();

        for ($i = 1; $i <= 5; $i++) {
            $students->push(
                User::updateOrCreate(
                    ['email' => "student$i@example.com"],
                    [
                        'name' => "Student $i",
                        'password' => Hash::make('password'),
                        'role' => 'student'
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | COURSES
        |--------------------------------------------------------------------------
        */

        $coursesData = [
            [
                'title' => 'Laravel Basic',
                'description' => 'Belajar Laravel dari dasar'
            ],
            [
                'title' => 'Laravel Advanced',
                'description' => 'Materi Laravel tingkat lanjut'
            ]
        ];

        $courses = collect();

        foreach ($coursesData as $data) {

            $courses->push(
                Course::updateOrCreate(
                    ['slug' => Str::slug($data['title'])],
                    [
                        'instructor_id' => $teacher->id,
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'thumbnail' => null,
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LESSONS
        |--------------------------------------------------------------------------
        */

        foreach ($courses as $course) {

            for ($i = 1; $i <= 5; $i++) {

                Lesson::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'position' => $i
                    ],
                    [
                        'title' => "Lesson $i - {$course->title}",
                        'content' => "Isi materi lesson $i"
                    ]
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ENROLLMENTS
        |--------------------------------------------------------------------------
        */

        foreach ($students as $student) {

            foreach ($courses as $course) {

                Enrollment::updateOrCreate([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
