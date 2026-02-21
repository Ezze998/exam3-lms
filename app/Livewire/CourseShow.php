<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class CourseShow extends Component
{
    public Course $course;
    public $enrolled = false;
    public $isInstructor = false;

    public function mount(Course $course)
    {
        $this->course = $course;

        if (Auth::check()) {
            $this->enrolled = $course->students()
                ->where('user_id', Auth::id())
                ->exists();

            $this->isInstructor = $course->instructor_id === Auth::id();
        }
    }

    public function enroll()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $already = $this->course->students()->where('user_id', Auth::id())->exists();
        if ($already) {
            session()->flash('info', 'You are already enrolled in this course.');
            $this->enrolled = true;
            return;
        }

        $this->course->students()->attach(Auth::id());
        $this->enrolled = true;
        session()->flash('success', 'Enrolled successfully.');
    }

    public function deleteLesson($lessonId)
    {
        if (!$this->isInstructor) {
            abort(403);
        }

        Lesson::find($lessonId)?->delete();
        $this->dispatch('lesson-updated');
        session()->flash('success', 'Lesson deleted successfully.');
    }

    public function unenrollStudent($studentId)
    {
        if (!$this->isInstructor) {
            abort(403);
        }

        $this->course->students()->detach($studentId);
        session()->flash('success', 'Student unenrolled successfully.');
    }

    public function render()
    {
        return view('components.course-show.course-show');
    }
}
