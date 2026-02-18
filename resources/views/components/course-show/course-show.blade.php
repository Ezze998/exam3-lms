<div class="grid md:grid-cols-3 gap-8 items-start">

    <div class="md:col-span-1">
        <div class="rounded-xl overflow-hidden shadow-md">
            <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/1200x600' }}" class="w-full h-64 object-cover">
        </div>
    </div>

    <div class="md:col-span-2 space-y-4">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-1">{{ $course->title }}</h1>
                <p class="text-sm text-gray-500">Instructor: {{ $course->instructor->name }}</p>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500">Students</div>
                <div class="text-xl font-semibold">{{ $course->students()->count() }}</div>
            </div>
        </div>

        <p class="text-gray-700">{{ $course->description }}</p>

        <div class="flex items-center gap-3">
            @if($enrolled)
                <a href="/classroom/{{ $course->id }}" class="btn btn-success">Go to Classroom</a>
            @else
                <button wire:click="enroll" class="btn btn-primary">Enroll Now</button>
            @endif
            @auth
                @if(auth()->user()->role === 'teacher' && auth()->id() === $course->instructor_id)
                    <a href="{{ route('teacher.lessons', $course->id) }}" class="btn btn-outline btn-sm">Manage Lessons</a>
                @endif
            @endauth
        </div>

        <div>
            <h2 class="text-xl font-semibold mt-4 mb-2">Lessons</h2>
            <div class="space-y-2">
                @foreach($course->lessons as $lesson)
                    <div class="p-3 bg-white rounded shadow flex items-center justify-between">
                        <div>
                            <div class="font-medium">{{ $lesson->title }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($lesson->content ?? '', 80) }}</div>
                        </div>
                        <div class="text-sm text-gray-400">{{ $lesson->duration ?? '' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
