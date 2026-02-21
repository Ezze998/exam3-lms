<x-layouts.app>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold">Welcome to InnoLearn</h1>
                </div>
                <div>
                    @auth
                        @if(auth()->user()->role === 'teacher')
                            <a href="/teacher/dashboard" class="btn btn-primary">Go to Teacher Dashboard</a>
                        @else
                            <a href="/dashboard" class="btn btn-primary">My Learning</a>
                        @endif
                    @else
                        <a href="/login" class="btn btn-primary">Get Started</a>
                    @endauth
                </div>
            </div>

            {{-- Stats cards (site-wide for guests, teacher-specific available via Livewire on dashboard) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @php
                    $totalStudents = \App\Models\User::where('role','student')->count();
                    $totalCourses = \App\Models\Course::count();
                    $latest = \App\Models\Course::latest()->first();
                @endphp

                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="text-sm text-gray-500">Students</div>
                    <div class="text-2xl font-bold">{{ $totalStudents }}</div>
                    <div class="text-xs text-gray-400 mt-2">Total learners on the platform</div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="text-sm text-gray-500">Courses</div>
                    <div class="text-2xl font-bold">{{ $totalCourses }}</div>
                    <div class="text-xs text-gray-400 mt-2">Available courses</div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow">
                    <div class="text-sm text-gray-500">Recent</div>
                    <div class="text-2xl font-bold">{{ $latest?->title ?? '-' }}</div>
                    <div class="text-xs text-gray-400 mt-2">Latest published course</div>
                </div>
            </div>

            {{-- Featured courses carousel --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-semibold">Featured Courses</h2>
                    <a href="/catalog" class="text-sm text-[#8b3f2f] font-semibold">View All Courses →</a>
                </div>

                <livewire:featured-courses-carousel />
            </div>

        </div>
    </section>

</x-layouts.app>
