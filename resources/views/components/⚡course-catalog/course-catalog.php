<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseCatalog extends Component
{
    public $search = '';

    public function render()
    {
        $courses = Course::with('instructor')
            ->where('title','like',"%{$this->search}%")
            ->latest()
            ->get();

        return view('livewire.course-catalog', compact('courses'));
    }
}

?>