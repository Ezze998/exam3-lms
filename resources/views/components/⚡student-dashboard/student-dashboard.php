<?php 

use Livewire\Component;

class StudentDashboard extends Component
{
    public function render()
    {
        $courses = auth()->user()
            ->courses()
            ->with('lessons')
            ->get();

        return view('livewire.student-dashboard', compact('courses'));
    }
}


?>

