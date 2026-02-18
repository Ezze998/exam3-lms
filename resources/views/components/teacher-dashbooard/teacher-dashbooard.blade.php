<div class="p-8 space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Teacher Dashboard</h1>
            <div class="text-sm text-gray-500">Courses: {{ $totalCourses ?? 0 }} — Students: {{ $totalStudents ?? 0 }}</div>
        </div>

        <div class="flex items-center gap-3">
            <a href="/teacher/course/create" class="btn btn-primary">+ New Course</a>
        </div>
    </div>

    <div class="space-y-6">

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                    <div class="h-36 bg-gray-100 overflow-hidden">
                        <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold">{{ $course->title }}</h3>
                            <div class="text-xs text-gray-500 mt-1">{{ $course->students()->count() }} students</div>
                        </div>
                        <div class="mt-3 flex justify-end gap-2">
                            <a href="{{ route('teacher.lessons',$course->id) }}" class="btn btn-sm btn-outline">Lessons</a>
                            <a href="{{ route('teacher.course.edit', $course->id) }}" class="btn btn-sm">Edit</a>
                            @if($course->trashed())
                                <button wire:click="restore({{ $course->id }})" class="btn btn-sm">Restore</button>
                            @else
                                <button wire:click="delete({{ $course->id }})" class="btn btn-sm btn-error">Archive</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    

</div>
