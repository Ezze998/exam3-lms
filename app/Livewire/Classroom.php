<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;

class Classroom extends Component
{
    public Course $course;
    public $lesson;
    public $isCompleted = false;

    public function mount(Course $course, $lessonId = null)
    {
        $this->course = $course;

        // ensure student is enrolled or is the instructor
        if (! auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $enrolled = $this->course->students()->where('user_id', $user->id)->exists();
        if (! $enrolled && $this->course->instructor_id !== $user->id) {
            abort(403);
        }

        if ($lessonId) {
            $this->lesson = Lesson::find($lessonId);
        } else {
            $this->lesson = $this->course->lessons()->orderBy('position')->first();
        }

        // set completion state for current user
        $this->isCompleted = auth()->check()
            ? auth()->user()->completedLessons()->where('lesson_id', $this->lesson->id)->exists()
            : false;
    }

    public function next()
    {
        $next = $this->course->lessons()->where('position', '>', $this->lesson->position)->orderBy('position')->first();
        if ($next) {
            $this->lesson = $next;
            $this->isCompleted = auth()->check() ? auth()->user()->completedLessons()->where('lesson_id', $this->lesson->id)->exists() : false;
        }
    }

    public function prev()
    {
        $prev = $this->course->lessons()->where('position', '<', $this->lesson->position)->orderBy('position', 'desc')->first();
        if ($prev) {
            $this->lesson = $prev;
            $this->isCompleted = auth()->check() ? auth()->user()->completedLessons()->where('lesson_id', $this->lesson->id)->exists() : false;
        }
    }

    public function markComplete()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

        auth()->user()->completedLessons()->syncWithoutDetaching($this->lesson->id);
        $this->isCompleted = true;
        session()->flash('success', 'Marked lesson complete.');
    }

    public function render()
    {
        return view('components.classroom.classroom');
    }
}
