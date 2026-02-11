<?php

use Livewire\Component;
use App\Models\Course;

class LandingFeatured extends Component
{
    public function render()
    {
        $courses = Course::latest()
            ->take(3)
            ->get();

        return view('livewire.landing-featured', compact('courses'));
    }
}

?>