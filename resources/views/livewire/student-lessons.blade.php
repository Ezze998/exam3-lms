<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-orange-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">Lessons</h1>
            <p class="text-amber-700">Continue learning where you left off</p>
        </div>

        <!-- Tabs -->
        <div class="flex gap-4 mb-8 border-b border-amber-200">
            <button
                wire:click="$set('status', 'new')"
                @class([
                    'px-6 py-3 font-medium border-b-2 transition-colors',
                    'border-amber-600 text-amber-600 bg-amber-50' => $status === 'new',
                    'border-transparent text-amber-500 hover:text-amber-600' => $status !== 'new',
                ])
            >
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                    </svg>
                    New Lessons
                </span>
            </button>
            <button
                wire:click="$set('status', 'completed')"
                @class([
                    'px-6 py-3 font-medium border-b-2 transition-colors',
                    'border-amber-600 text-amber-600 bg-amber-50' => $status === 'completed',
                    'border-transparent text-amber-500 hover:text-amber-600' => $status !== 'completed',
                ])
            >
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Completed
                </span>
            </button>
        </div>

        <!-- Lessons List -->
        @if ($lessons->count() > 0)
            <div class="space-y-4">
                @foreach ($lessons as $lesson)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-100 overflow-hidden">
                        <div class="p-6 flex items-start justify-between gap-6">
                            <!-- Content -->
                            <div class="flex-1">
                                <!-- Course Badge -->
                                <div class="inline-block mb-2">
                                    <a href="{{ route('course.show', $lesson->course) }}" class="text-xs font-semibold text-amber-600 hover:text-amber-700 uppercase tracking-wide">
                                        {{ $lesson->course->title }}
                                    </a>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-semibold text-amber-900 mb-2">{{ $lesson->title }}</h3>

                                <!-- Meta -->
                                <div class="flex items-center gap-4 text-sm text-amber-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0-1a1 1 0 00-1 1v1H4a1 1 0 00-1 1v1h14V3a1 1 0 00-1-1h-1V1a1 1 0 00-2 0v1H7V1zm9 5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $lesson->created_at->format('M d, Y') }}
                                    </span>

                                    @if ($status === 'completed')
                                        <span class="flex items-center gap-1 text-green-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Completed
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('course.show', $lesson->course) }}" class="flex-shrink-0 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 whitespace-nowrap">
                                View Lesson
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                @if ($status === 'completed')
                    <svg class="w-20 h-20 text-amber-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-amber-900 mb-2">No Completed Lessons Yet</h3>
                    <p class="text-amber-700 mb-6">Start a lesson from your courses to get began!</p>
                @else
                    <svg class="w-20 h-20 text-amber-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-amber-900 mb-2">No New Lessons</h3>
                    <p class="text-amber-700">All lessons from your courses are already in progress or completed.</p>
                @endif
            </div>
        @endif
    </div>
</div>
