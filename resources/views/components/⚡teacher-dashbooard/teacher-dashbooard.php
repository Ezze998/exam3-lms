<?php

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $courses = [];

    protected $listeners = ['refreshCourses' => 'loadCourses'];

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::where('instructor_id', Auth::id())->get();
    }

    public function delete($id)
    {
        Course::find($id)?->delete();
        $this->loadCourses();
    }

    
};
