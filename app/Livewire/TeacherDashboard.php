<?php


use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component
{
    public $courses = [];
    public $totalCourses = 0;
    public $totalStudents = 0;

    protected $listeners = ['refreshCourses' => 'loadCourses'];

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::withTrashed()->where('instructor_id', Auth::id())->get();
        $this->totalCourses = $this->courses->count();
        $this->totalStudents = $this->courses->map(function($c){
            return $c->students()->count();
        })->sum();
    }

    public function delete($id)
    {
        Course::find($id)?->delete();
        $this->loadCourses();
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->find($id);
        if ($course && $course->trashed()) {
            $course->restore();
        }
        $this->loadCourses();
    }

    public function render()
    {
        return view('components.teacher-dashbooard.teacher-dashbooard');
    }
}
