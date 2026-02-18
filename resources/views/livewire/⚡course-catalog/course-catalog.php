<?php

use Livewire\Component;
use App\Models\Course;

new class extends Component
{
    public $search = '';

    public function render()
    {
        $courses = Course::with('instructor')
            ->where('title','like',"%{$this->search}%")
            ->latest()
            ->get();

        return compact('courses'); 
    }
};
