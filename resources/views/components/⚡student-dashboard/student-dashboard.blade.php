<div>

<h1 class="text-3xl font-bold mb-6">
    My Learning
</h1>

<div class="grid md:grid-cols-3 gap-6">

@foreach($courses as $course)

<div class="card bg-base-100 shadow">

    <div class="card-body">

        <h2 class="card-title">
            {{ $course->title }}
        </h2>

        {{-- simple progress --}}
        <progress
            class="progress progress-primary w-full"
            value="100"
            max="100">
        </progress>

        <a href="/classroom/{{ $course->id }}"
           class="btn btn-primary btn-sm mt-2">
            Continue
        </a>

    </div>

</div>

@endforeach

</div>

</div>
