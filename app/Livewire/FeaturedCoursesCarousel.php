<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class FeaturedCoursesCarousel extends Component
{
    public $courses = [];
    public $currentIndex = 0;
    public $autoScrollEnabled = true;

    public function mount()
    {
        // Fetch all courses for the carousel
        $this->courses = Course::latest()->get()->toArray();
        if (empty($this->courses)) {
            $this->courses = [];
        }
    }

    public function nextSlide()
    {
        if (!empty($this->courses)) {
            $this->currentIndex = ($this->currentIndex + 1) % count($this->courses);
            $this->resetAutoScroll();
        }
    }

    public function prevSlide()
    {
        if (!empty($this->courses)) {
            $this->currentIndex = ($this->currentIndex - 1 + count($this->courses)) % count($this->courses);
            $this->resetAutoScroll();
        }
    }

    public function goToSlide($index)
    {
        if (isset($this->courses[$index])) {
            $this->currentIndex = $index;
            $this->resetAutoScroll();
        }
    }

    public function resetAutoScroll()
    {
        // Reset auto-scroll timer via JS
        $this->dispatch('reset-carousel-timer');
    }

    public function render()
    {
        return view('livewire.featured-courses-carousel');
    }
}
