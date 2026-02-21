<div class="px-6 py-8">
    <div class="max-w-6xl mx-auto">
        
        {{-- Course Header --}}
        <div class="grid md:grid-cols-3 gap-8 items-start mb-12">

            <div class="md:col-span-1">
                <div class="rounded-xl overflow-hidden shadow-md sticky top-8">
                    <img src="{{ $course->thumbnail ?? 'https://placehold.co/1200x600' }}" class="w-full h-64 object-cover">
                </div>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-[#8b3f2f] mb-1">{{ $course->title }}</h1>
                        <p class="text-sm text-gray-600">Instructor: <span class="font-semibold">{{ $course->instructor->name }}</span></p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Students</div>
                        <div class="text-2xl font-bold text-[#8b3f2f]">{{ $course->students()->count() }}</div>
                    </div>
                </div>

                <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>

                {{-- Student/Teacher Actions --}}
                <div class="flex flex-wrap items-center gap-3 mt-6">
                    @if($enrolled)
                        <a href="/classroom/{{ $course->id }}" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2 1m2-1l-2-1m2 1v2.5"></path>
                            </svg>
                            Go to Classroom
                        </a>
                    @else
                        <button wire:click="enroll" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Enroll Now
                        </button>
                    @endif

                    @if($isInstructor)
                        <a href="{{ route('teacher.lessons', $course->id) }}" class="btn btn-outline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Lesson
                        </a>
                        <a href="{{ route('teacher.course.edit', $course->id) }}" class="btn btn-outline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Course
                        </a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Lessons Section --}}
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#8b3f2f]">Lessons</h2>
                @if($isInstructor)
                    <a href="{{ route('teacher.lessons', $course->id) }}" class="text-sm text-[#8b3f2f] font-semibold">+ New Lesson</a>
                @endif
            </div>

            @php
                $lessonsToShow = $isInstructor 
                    ? $course->lessons
                    : $course->lessons->where('status', 'published');
            @endphp

            @if($lessonsToShow->count() > 0)
                <div class="space-y-3">
                    @foreach($lessonsToShow as $lesson)
                        <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between hover:shadow-md transition">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-[#8b3f2f]">{{ $lesson->title }}</h3>
                                    @if($isInstructor && $lesson->status === 'draft')
                                        <span class="badge badge-outline badge-sm">Draft</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($lesson->content ?? '', 100) }}</p>
                            </div>
                            @if($isInstructor)
                                <div class="flex items-center gap-2 ml-4">
                                    <a href="{{ route('teacher.lessons', $course->id) }}?edit={{ $lesson->id }}" class="btn btn-sm btn-ghost">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="deleteLesson({{ $lesson->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this lesson?')"
                                            class="btn btn-sm btn-ghost text-error">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">
                        @if($isInstructor)
                            No lessons added yet
                        @else
                            No published lessons available yet
                        @endif
                    </p>
                    @if($isInstructor)
                        <a href="{{ route('teacher.lessons', $course->id) }}" class="text-sm text-[#8b3f2f] font-semibold mt-2 inline-block">
                            Create the first lesson →
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Students Section (Teachers Only) --}}
        @if($isInstructor)
            <div>
                <h2 class="text-2xl font-bold text-[#8b3f2f] mb-6">Enrolled Students</h2>

                @if($course->students->count() > 0)
                    <div class="grid gap-3">
                        @foreach($course->students as $student)
                            <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-[#8b3f2f] flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                    </div>
                                </div>
                                <button wire:click="unenrollStudent({{ $student->id }})"
                                        onclick="return confirm('Are you sure you want to unenroll this student?')"
                                        class="btn btn-sm btn-outline btn-error">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">No students enrolled yet</p>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
