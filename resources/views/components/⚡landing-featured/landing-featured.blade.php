<div class="space-y-20">

{{-- ================= HERO DINAMIS ================= --}}
@if($heroCourse)

<div
    class="hero min-h-[75vh] rounded-3xl shadow-xl overflow-hidden relative text-white"
    style="background-image: url('{{ $heroCourse->thumbnail_url ?? 'https://placehold.co/1600x800' }}'); background-size: cover; background-position: center;"
>

    {{-- overlay gelap --}}
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="hero-content relative z-10 text-center">

        <div class="max-w-2xl">

            <h1 class="text-5xl font-bold mb-4">
                {{ $heroCourse->title }}
            </h1>

            <p class="mb-4 text-lg opacity-90">
                by {{ $heroCourse->instructor->name }}
            </p>

            <p class="mb-6 line-clamp-3">
                {{ $heroCourse->description }}
            </p>

            <div class="flex justify-center gap-4">

                <a href="/courses/{{ $heroCourse->id }}"
                   class="btn btn-outline btn-lg">
                    View Details
                </a>

                <button
                    wire:click="enroll({{ $heroCourse->id }})"
                    class="btn btn-primary btn-lg">
                    Enroll Now
                </button>

            </div>

        </div>

    </div>
</div>

@endif



{{-- ================= SLIDER COURSES ================= --}}
@if($courses->count())

<div>

    <h2 class="text-3xl font-bold mb-6">
        New Courses
    </h2>

    <div class="flex gap-6 overflow-x-auto scroll-smooth">

        @foreach($courses as $course)

        <div class="card w-72 bg-base-100 shadow-xl flex-shrink-0">

            <figure>
                <img src="{{ $course->thumbnail_url ?? 'https://placehold.co/600x400' }}"
                     class="h-40 w-full object-cover">
            </figure>

            <div class="card-body">

                <h2 class="card-title text-sm">
                    {{ $course->title }}
                </h2>

                <p class="text-xs opacity-60">
                    {{ $course->instructor->name }}
                </p>

                <div class="card-actions justify-between">

                    <a href="/courses/{{ $course->id }}"
                       class="btn btn-ghost btn-xs">
                        Details
                    </a>

                    <button
                        wire:click="enroll({{ $course->id }})"
                        class="btn btn-primary btn-xs">
                        Enroll
                    </button>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endif

</div>
