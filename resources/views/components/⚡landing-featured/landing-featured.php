<?php

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = Course::with('instructor')
            ->latest()
            ->take(8)
            ->get();
    }

    public function enroll($courseId)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        Auth::user()
            ->courses()
            ->syncWithoutDetaching($courseId);

        session()->flash('success', 'Successfully enrolled!');
    }
};