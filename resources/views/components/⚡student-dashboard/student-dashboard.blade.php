<div class="space-y-8">

<h1 class="text-3xl font-bold">
    My Learning
</h1>


@if(count($courses) == 0)

    <div class="alert">
        You haven't enrolled in any courses yet.
        <a href="/catalog" class="btn btn-sm btn-primary ml-4">
            Browse Courses
        </a>
    </div>

@else

<div class="grid md:grid-cols-3 gap-6">

@foreach($courses as $course)

<div class="card bg-base-100 shadow-xl hover:shadow-2xl transition">

    <figure>
        <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
             class="h-40 w-full object-cover">
    </figure>

    <div class="card-body">

        <h2 class="card-title">
            {{ $course->title }}
        </h2>

        {{-- Progress --}}
        <div>
            <p class="text-sm mb-1">
                Progress {{ $course->progress }}%
            </p>

            <progress
                class="progress progress-primary w-full"
                value="{{ $course->progress }}"
                max="100">
            </progress>
        </div>

        <div class="card-actions justify-end mt-4">

            <a href="/classroom/{{ $course->id }}"
               class="btn btn-primary btn-sm">
                Continue
            </a>

        </div>

    </div>

</div>

@endforeach

</div>

@endif

</div>
