<div>

<div class="mb-6">
    <input
        wire:model.live="search"
        placeholder="Search course..."
        class="input input-bordered w-full md:w-1/2 mb-6 rounded-full px-4">
</div>

<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

@foreach($courses as $course)

<div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 flex flex-col">

    <div class="relative h-44 bg-gray-100 overflow-hidden">
        <img src="{{ $course->thumbnail ?? 'https://placehold.co/600x400' }}" class="w-full h-full object-cover">
        <div class="absolute top-3 right-3 bg-white/90 text-xs text-gray-700 px-2 py-1 rounded">{{ $course->lessons->count() }} lessons</div>
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold mb-1">{{ $course->title }}</h3>
        <p class="text-xs uppercase tracking-wider text-[#8b3f2f] mb-2">{{ $course->instructor->name }}</p>
        <p class="text-sm text-gray-600 mb-4 flex-1">{{ Str::limit($course->description, 100) }}</p>

        <div class="flex items-center justify-between mt-2">
            <a href="/courses/{{ $course->id }}" class="btn btn-primary btn-sm">View</a>
            <div class="text-xs text-gray-400">{{ $course->students()->count() }} students</div>
        </div>
    </div>

</div>

@endforeach

</div>
</div>
