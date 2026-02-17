<x-layouts.app-auth>

<div class="p-8 space-y-8">

    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Teacher Dashboard</h1>

        <button onclick="course_modal.showModal()" class="btn btn-primary">
            + New Course
        </button>
    </div>


    <div class="grid md:grid-cols-3 gap-6">

        @foreach($courses as $course)

        <div class="card bg-base-100 shadow-xl">

            <figure>
                <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
                     class="h-40 w-full object-cover">
            </figure>

            <div class="card-body">

                <h2 class="card-title">{{ $course->title }}</h2>

                <div class="card-actions justify-end">

                    <a href="{{ route('teacher.lessons',$course->id) }}"
                       class="btn btn-sm btn-outline">
                        Lessons
                    </a>

                    <button
                        wire:click="delete({{ $course->id }})"
                        class="btn btn-sm btn-error">
                        Delete
                    </button>

                </div>

            </div>
        </div>

        @endforeach

    </div>

    <dialog id="course_modal" class="modal">
        <div class="modal-box">
            <livewire:course-form />
        </div>
    </dialog>

</div>

</x-layouts.app-auth>
