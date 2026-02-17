<?php 

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $courses = [];

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Auth::user()
            ->courses()
            ->with('lessons')
            ->get()
            ->map(function ($course) {

                // progress sederhana (sementara)
                $totalLessons = $course->lessons->count();
                $completed = 0; // nanti kita upgrade real progress

                $course->progress = $totalLessons > 0
                    ? round(($completed / $totalLessons) * 100)
                    : 0;

                return $course;
            });
    }

}


?>

