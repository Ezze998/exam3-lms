<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-orange-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">My Courses</h1>
            <p class="text-amber-700">Explore and manage your enrolled courses</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Search courses..."
                    class="w-full px-4 py-3 rounded-lg border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent text-amber-900 placeholder-amber-500"
                />
                <svg class="absolute right-3 top-3.5 w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Courses Grid -->
        @if ($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($courses as $course)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 border border-amber-100 overflow-hidden">
                        <!-- Thumbnail -->
                        <div class="h-40 bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center">
                            @if ($course->thumbnail)
                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-amber-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-amber-900 mb-1 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-sm text-amber-700 mb-4">By <span class="font-medium">{{ $course->instructor->name }}</span></p>

                            <!-- Stats -->
                            <div class="flex items-center gap-4 mb-4 text-sm text-amber-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5"></path>
                                        <path d="M6.5 10h7M6.5 13h7M6.5 7h2"></path>
                                    </svg>
                                    <span>{{ $course->lessons_count }} lessons</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                    <span>Oct 15, 2025</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-amber-600 mb-1">
                                    <span>Progress</span>
                                    <span>65%</span>
                                </div>
                                <div class="w-full bg-amber-100 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>

                            <!-- Go to Course Button -->
                            <a href="{{ route('course.show', $course) }}" class="block w-full text-center bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium py-2 rounded-lg transition-all duration-200 transform hover:scale-105">
                                Go to Course
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $courses->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-amber-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-amber-900 mb-2">No Courses Yet</h3>
                <p class="text-amber-700 mb-6">You haven't enrolled in any courses yet.</p>
                <a href="/catalog" class="inline-block bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 transform hover:scale-105">
                    Browse Courses
                </a>
            </div>
        @endif
    </div>
</div>
