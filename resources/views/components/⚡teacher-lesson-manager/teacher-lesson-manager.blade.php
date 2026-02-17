<x-layouts.app-auth>

<div class="p-8 space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">
            Lessons — {{ $course->title }}
        </h1>

        <button onclick="lesson_modal.showModal()" class="btn btn-primary">
            + Add Lesson
        </button>
    </div>


    @foreach($lessons as $lesson)
        <div class="card bg-base-100 shadow p-4 flex justify-between">

            <span>
                {{ $lesson->order }}. {{ $lesson->title }}
            </span>

            <button wire:click="delete({{ $lesson->id }})"
                    class="btn btn-error btn-sm">
                Delete
            </button>

        </div>
    @endforeach


    <dialog id="lesson_modal" class="modal">
        <div class="modal-box">
            <livewire:teacher-lesson-form :course="$course"/>
        </div>
    </dialog>

</div>

</x-layouts.app-auth>
