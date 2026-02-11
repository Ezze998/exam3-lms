<div class="space-y-16">

{{-- ================= HERO ================= --}}
<div class="hero min-h-[70vh] rounded-3xl bg-gradient-to-r from-primary to-secondary text-primary-content shadow-xl">

    <div class="hero-content text-center">
        <div class="max-w-2xl">

            <h1 class="text-5xl font-bold mb-6">
                Learn Anything, Anytime 🚀
            </h1>

            <p class="mb-6 text-lg opacity-90">
                Explore our newest courses and start learning today with expert instructors.
            </p>

            <a href="/catalog" class="btn btn-accent btn-lg">
                Browse All Courses
            </a>

        </div>
    </div>

</div>


{{-- ================= FEATURED COURSES ================= --}}
<div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">
            Newest Courses
        </h2>

        <div class="space-x-2">
            <button onclick="scrollLeft()" class="btn btn-circle">❮</button>
            <button onclick="scrollRight()" class="btn btn-circle">❯</button>
        </div>
    </div>


    {{-- horizontal scroll container --}}
    <div id="courseSlider"
         class="flex gap-6 overflow-x-auto scroll-smooth pb-4">

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
                    by {{ $course->instructor->name }}
                </p>

                <div class="card-actions justify-between mt-3">

                    <a href="/courses/{{ $course->id }}"
                       class="btn btn-ghost btn-xs">
                        Details
                    </a>

                    <button
                        wire:click="enroll({{ $course->id }})"
                        class="btn btn-primary btn-xs">
                        Enroll Now
                    </button>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>


{{-- ================= SIMPLE JS FOR SCROLL ================= --}}
<script>
function scrollLeft() {
    document.getElementById('courseSlider').scrollBy({
        left: -400,
        behavior: 'smooth'
    });
}

function scrollRight() {
    document.getElementById('courseSlider').scrollBy({
        left: 400,
        behavior: 'smooth'
    });
}
</script>

</div>
