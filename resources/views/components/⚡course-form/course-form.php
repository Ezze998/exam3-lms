<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithFileUploads;

    public $title, $description, $thumbnail;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'thumbnail' => 'image|max:2048'
    ];

    public function save()
    {
        $this->validate();

        $path = $this->thumbnail
            ? $this->thumbnail->store('thumbnails', 'public')
            : null;

        Course::create([
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail_url' => $path,
            'instructor_id' => Auth::id(),
        ]);

        $this->dispatch('refreshCourses');

        $this->reset();
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.teacher.course-form');
    }
}
