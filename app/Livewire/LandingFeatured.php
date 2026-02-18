<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class LandingFeatured extends Component
{
    public $heroCourse;
    public $courses;

    public function mount()
    {
        $all = Course::with('instructor')
            ->latest()
            ->take(9)
            ->get();

        $this->heroCourse = $all->first();
        $this->courses = $all->skip(1);
    }

    public function enroll($courseId)
    {
        if (!auth()->check()) {
            return redirect()->to('/login');
        }

        auth()->user()->courses()->syncWithoutDetaching($courseId);
        session()->flash('success', 'Successfully enrolled!');
    }

    public function render()
    {
        return view('components.landing-featured.landing-featured');
    }
}
