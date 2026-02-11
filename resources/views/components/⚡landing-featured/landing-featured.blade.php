<div>

<h1 class="text-4xl font-bold text-center mb-10">
    Welcome to LMS
</h1>

<h2 class="text-2xl font-semibold mb-6">
    Featured Courses
</h2>

<div class="grid md:grid-cols-3 gap-6">

@foreach($courses as $course)
<div class="card bg-base-100 shadow-xl">

    <figure>
        <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
             class="h-40 w-full object-cover">
    </figure>

    <div class="card-body">
        <h2 class="card-title">{{ $course->title }}</h2>

        <p class="text-sm text-gray-500">
            by {{ $course->instructor->name }}
        </p>

        <a href="/courses/{{ $course->id }}"
           class="btn btn-primary btn-sm">
            View Course
        </a>
    </div>

</div>
@endforeach

</div>

</div>
