<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentLessons extends Component
{
    public $status = 'new'; // 'new', 'completed'

    public function render()
    {
        $user = Auth::user();

        // Get published lessons from enrolled courses
        if ($this->status === 'completed') {
            $lessons = $user->completedLessons()
                ->with(['course'])
                ->where('status', 'published')
                ->orderBy('lesson_user.updated_at', 'desc')
                ->get();
        } else {
            // New lessons from enrolled courses
            $lessons = \App\Models\Lesson::whereHas('course', function ($query) use ($user) {
                $query->whereIn('id', $user->courses()->pluck('courses.id'));
            })
            ->where('status', 'published')
            ->whereNotIn('id', $user->completedLessons()->pluck('lessons.id'))
            ->with(['course'])
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('livewire.student-lessons', [
            'lessons' => $lessons,
        ]);
    }
}
