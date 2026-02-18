<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentDashboard extends Component
{
    public $courses = [];

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Auth::user()
            ->courses()
            ->with('lessons')
            ->get()
            ->map(function ($course) {
                $totalLessons = $course->lessons->count();
                $completed = 0;
                $course->progress = $totalLessons > 0
                    ? round(($completed / $totalLessons) * 100)
                    : 0;
                return $course;
            });
    }

    public function render()
                                $totalLessons = $course->lessons->count();
                                $completed = Auth::user()->completedLessons()->where('course_id', $course->id)->count();

                                $course->progress = $totalLessons > 0
                                    ? round(($completed / $totalLessons) * 100)
                                    : 0;
