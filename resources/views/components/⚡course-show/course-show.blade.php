<div class="grid md:grid-cols-3 gap-8">

<img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
     class="rounded-xl">

<div class="md:col-span-2">

<h1 class="text-3xl font-bold mb-3">
    {{ $course->title }}
</h1>

<p class="mb-4">
    Instructor: {{ $course->instructor->name }}
</p>

<p class="mb-6">
    {{ $course->description }}
</p>


{{-- enroll button --}}
@if($enrolled)
    <a href="/classroom/{{ $course->id }}"
       class="btn btn-success">
        Go to Classroom
    </a>
@else
    <button wire:click="enroll"
            class="btn btn-primary">
        Enroll Now
    </button>
@endif


<div class="divider">Lessons</div>

<ul class="menu bg-base-100 rounded-box">

@foreach($course->lessons as $lesson)
    <li>
        <a class="opacity-50 cursor-not-allowed">
            🔒 {{ $lesson->title }}
        </a>
    </li>
@endforeach

</ul>

</div>
</div>
