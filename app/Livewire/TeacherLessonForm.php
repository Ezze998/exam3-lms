<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Course;

class TeacherLessonForm extends Component
{
    public Course $course;
    public $title;
    public $video_url;
    public $order;

    protected $rules = [
        'title' => 'required',
        'video_url' => 'required|url',
        'order' => 'required|integer',
    ];

    public function save()
    {
        $this->validate();

        Lesson::create([
            'course_id' => $this->course->id,
            'title' => $this->title,
            'video_url' => $this->video_url,
            'order' => $this->order,
        ]);

        $this->emit('refreshLessons');

        $this->reset(['title', 'video_url', 'order']);
    }

    public function render()
    {
        return view('components.teacher-lesson-form.teacher-lesson-form');
    }
}
