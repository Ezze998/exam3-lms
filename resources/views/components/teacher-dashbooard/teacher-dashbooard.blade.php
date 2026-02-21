<div class="min-h-screen bg-gradient-to-b from-[#fdebd0] to-white">
    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12">
            <div>
                <h1 class="text-4xl font-bold text-[#8b3f2f] mb-2">My Courses</h1>
                <p class="text-gray-600">Manage your courses, lessons, and students</p>
            </div>

            <a href="/teacher/course/create" class="btn btn-primary mt-4 md:mt-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Course
            </a>
        </div>

        {{-- Course Grid --}}
        @if($courses->count() > 0)
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition flex flex-col">
                        {{-- Thumbnail --}}
                        <div class="h-40 bg-gray-100 overflow-hidden relative">
                            <img src="{{ $course->thumbnail ?? 'https://placehold.co/600x400' }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            @if($course->trashed())
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                    <span class="bg-red-500 text-white px-3 py-1 rounded text-sm font-semibold">Archived</span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-[#8b3f2f] line-clamp-2">{{ $course->title }}</h3>
                                <div class="flex items-center gap-4 mt-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.105 3.07 9.772 7.5 11.996m0-13c5.5 0 10 4.745 10 10.997 0 5.105-3.07 9.772-7.5 11.998"></path>
                                        </svg>
                                        <span>{{ $course->lessons->count() }} lessons</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $course->students()->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-4 flex flex-col gap-2">
                                <a href="/courses/{{ $course->id }}" class="btn btn-sm btn-outline btn-block">
                                    View
                                </a>
                                <div class="flex gap-2">
                                    <a href="{{ route('teacher.lessons', $course->id) }}" 
                                       class="btn btn-sm btn-outline flex-1">
                                        Lessons
                                    </a>
                                    <a href="{{ route('teacher.course.edit', $course->id) }}" 
                                       class="btn btn-sm btn-outline flex-1">
                                        Edit
                                    </a>
                                </div>
                                @if($course->trashed())
                                    <button wire:click="restore({{ $course->id }})" 
                                            class="btn btn-sm btn-success">
                                        Restore
                                    </button>
                                @else
                                    <button wire:click="delete({{ $course->id }})" 
                                            onclick="return confirm('Archive this course?')"
                                            class="btn btn-sm btn-error">
                                        Archive
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg mb-4">No courses yet</p>
                <a href="/teacher/course/create" class="btn btn-primary">
                    Create Your First Course
                </a>
            </div>
        @endif

    </div>
</div>
