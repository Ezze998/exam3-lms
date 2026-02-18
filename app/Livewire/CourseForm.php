<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function mount(Course $course = null)
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

        $path = null;
        if ($this->thumbnail) {
            try {
                $path = $this->thumbnail->store('thumbnails', 'public');
                } catch (\Exception $e) {
                Log::error('Thumbnail store failed: ' . $e->getMessage());
                // continue without thumbnail but inform client
                if (method_exists($this, 'dispatch')) {
                    $this->dispatch('save-error', ['message' => 'Thumbnail upload failed, saving without thumbnail.']);
                } else {
                    $this->dispatchBrowserEvent('save-error', ['message' => 'Thumbnail upload failed, saving without thumbnail.']);
                }
                $path = null;
            }
        }

        try {
            if ($this->course) {
            // update existing
            $this->course->update([
                'title' => $this->title,
                'description' => $this->description,
                'thumbnail_url' => $path ?? $this->course->thumbnail_url,
            ]);
        } else {
            Course::create([
                'title' => $this->title,
                'description' => $this->description,
                'thumbnail_url' => $path,
                'instructor_id' => Auth::id(),
            ]);
        }

            // notify parent(s), reset state and close modal
            $this->emit('refreshCourses');
            $this->emitUp('refreshCourses');
            $this->resetValidation();
            $this->reset(['title','description','thumbnail','course']);
            // dispatch both a Livewire dispatch event and an emit so listeners catch it
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('close-course-modal');
                $this->dispatch('closeModal');
            } else {
                $this->dispatchBrowserEvent('close-course-modal');
                $this->dispatchBrowserEvent('closeModal');
            }
            $this->emit('closeModal');
            session()->flash('success', 'Course saved.');
        } catch (\Exception $e) {
            Log::error('Course save failed: ' . $e->getMessage());
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('save-error', ['message' => 'Failed to save course: ' . $e->getMessage()]);
            } else {
                $this->dispatchBrowserEvent('save-error', ['message' => 'Failed to save course: ' . $e->getMessage()]);
            }
            session()->flash('error', 'Failed to save course.');
        }
    }

    public function render()
    {
        return view('components.course-form.course-form');
    }
}
