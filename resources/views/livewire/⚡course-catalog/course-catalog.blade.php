<div>

<input
    wire:model.live="search"
    placeholder="Search course..."
    class="input input-bordered w-full mb-6">

<div class="grid md:grid-cols-3 gap-6">

@foreach($courses as $course)

<div class="card bg-base-100 shadow">

    <figure>
        <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
             class="h-40 w-full object-cover">
    </figure>

    <div class="card-body">

        <h2 class="card-title">{{ $course->title }}</h2>

        <p class="text-sm">
            Instructor: {{ $course->instructor->name }}
        </p>

        <p class="text-xs text-gray-500">
            {{ Str::limit($course->description, 80) }}
        </p>

        <a href="/courses/{{ $course->id }}"
           class="btn btn-primary btn-sm">
            View
        </a>

    </div>

</div>

@endforeach

</div>
</div>
