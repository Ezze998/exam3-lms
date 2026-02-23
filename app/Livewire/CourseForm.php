<?php

namespace App\Livewire;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourseForm extends Component
{
    use WithFileUploads;

    public ?Course $course = null;

    public $title;

    public $description;

    public $thumbnail;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'thumbnail' => 'nullable|image|max:2048',
    ];

    public function mount(?Course $course = null)
    {
        if ($course) {
            $this->course = $course;
            $this->title = $course->title;
            $this->description = $course->description;
            $this->thumbnail = null;
        }
    }

    public function save()
    {
        $this->validate();

        $path = "";
        if ($this->thumbnail) {

        }

            try {
                $path = $this->thumbnail->store('thumbnails', 'public');
            } catch (\Exception $e) {
                Log::error('Thumbnail store failed: '.$e->getMessage());
                session()->flash('warning', 'Thumbnail upload failed, saving without thumbnail.');
                $path = null;
            }

        try {
            Course::create([
                'title' => $this->title,
                'description' => $this->description,
                'thumbnail' => $path,
                'instructor_id' => Auth::id(),
                'slug' => \Illuminate\Support\Str::slug($this->title),
            ]);

            // Dispatch to refresh courses and close modal
            $this->dispatch('refreshCourses');
            $this->dispatch('closeModal');
            $this->resetValidation();
            $this->reset(['title', 'description', 'thumbnail', 'course']);
            session()->flash('success', 'Course saved successfully!');
            return redirect()->route('teacher.dashboard');
        } catch (\Exception $e) {
            Log::error('Course save failed: '.$e->getMessage(), ['exception' => $e]);
            session()->flash('error', 'Failed to save course: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('components.course-form.course-form');
    }
}
