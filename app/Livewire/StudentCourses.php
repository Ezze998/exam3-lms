<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class StudentCourses extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        // Get enrolled courses with pagination
        $courses = $user->courses()
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                }
            })
            ->withCount('lessons')
            ->paginate($this->perPage);

        return view('livewire.student-courses', [
            'courses' => $courses,
        ]);
    }
}
