<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseShow extends Component
{
    public Course $course;
    public $enrolled = false;

    public function mount(Course $course)
    {
        $this->course = $course;

        if (auth()->check()) {
            $this->enrolled = $course->students()
                ->where('user_id', auth()->id())
                ->exists();
        }
    }

    public function enroll()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

        $already = $this->course->students()->where('user_id', auth()->id())->exists();
        if ($already) {
            session()->flash('info', 'You are already enrolled in this course.');
            $this->enrolled = true;
            return;
        }

        $this->course->students()->attach(auth()->id());
        $this->enrolled = true;
        session()->flash('success', 'Enrolled successfully.');
    }

    public function render()
    {
        return view('components.course-show.course-show');
    }
}
