<?php

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $heroCourse;
    public $courses;

    public function mount()
    {
        $all = Course::with('instructor')
            ->latest()
            ->take(9)
            ->get();

        // course paling baru untuk hero
        $this->heroCourse = $all->first();

        // sisanya untuk slider
        $this->courses = $all->skip(1);
    }

    public function enroll($courseId)
{
    if (!Auth::check()) {
        return redirect()->to('/login');
    }

    Auth::user()
        ->courses()
        ->syncWithoutDetaching($courseId);

    session()->flash('success', 'Successfully enrolled!');
}

};