<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseShow extends Component
{
    public Course $course;
    public $enrolled = false;

    public function mount(Course $course)
    {
        $this->course = $course;

        if(auth()->check()){
            $this->enrolled = $course->students()
                ->where('user_id', auth()->id())
                ->exists();
        }
    }

    public function enroll()
    {
        if(!auth()->check()){
            return redirect('/login');
        }

        $this->course->students()
            ->syncWithoutDetaching(auth()->id());

        $this->enrolled = true;
    }

    public function render()
    {
        return view('livewire.course-show');
    }
}

?>