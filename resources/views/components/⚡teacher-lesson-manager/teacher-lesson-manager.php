<?php

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;

new class extends Component
{
    public Course $course;
    public $lessons = [];

    protected $listeners = ['refreshLessons' => 'loadLessons'];

    public function mount(Course $course)
    {
        abort_if($course->instructor_id !== auth()->id(), 403);

        $this->course = $course;
        $this->loadLessons();
    }

    public function loadLessons()
    {
        $this->lessons = $this->course
            ->lessons()
            ->orderBy('order')
            ->get();
    }

    public function delete($id)
    {
        Lesson::find($id)?->delete();
        $this->loadLessons();
    }

    public function render()
    {
        return view('components.teacher-lesson-manager.teacher-lesson-manager');
    }
};
