<div class="carousel-container relative bg-white rounded-lg shadow-lg overflow-hidden">
    @if(!empty($courses))
        <div class="relative">
            <!-- Carousel slides -->
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500" style="transform: translateX(-{{ $currentIndex * 100 }}%)">
                    @foreach($courses as $index => $course)
                        <div class="w-full shrink-0">
                            <div class="flex flex-col md:flex-row h-96">
                                <!-- Thumbnail -->
                                <div class="md:w-1/3 h-48 md:h-full bg-gray-100 overflow-hidden">
                                    <img src="{{ asset('storage/' . $course['thumbnail']) }}" 
                                         class="w-full h-full object-cover" 
                                         alt="{{ $course['title'] }}">
                                </div>

                                <!-- Content -->
                                <div class="md:w-2/3 p-8 flex flex-col justify-center">
                                    <h3 class="text-3xl font-bold text-[#8b3f2f] mb-2">{{ $course['title'] }}</h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $course['description'] }}</p>
                                    <div class="flex items-center gap-4 mb-6">
                                        <span class="text-sm text-gray-500">
                                            <span class="font-semibold text-[#6b2f1f]">{{ \App\Models\Course::find($course['id'])->students()->count() }}</span> students enrolled
                                        </span>
                                    </div>
                                    <a href="/courses/{{ $course['id'] }}" class="btn btn-primary w-fit">
                                        View Course →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Previous Button -->
            <button wire:click="prevSlide" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-3 rounded-full shadow-md transition">
                <svg class="w-6 h-6 text-[#8b3f2f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button wire:click="nextSlide" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-3 rounded-full shadow-md transition">
                <svg class="w-6 h-6 text-[#8b3f2f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Slide Indicators -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-10">
                @foreach($courses as $index => $course)
                    <button wire:click="goToSlide({{ $index }})" 
                            class="w-3 h-3 rounded-full transition {{ $currentIndex === $index ? 'bg-[#8b3f2f]' : 'bg-gray-300' }}">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Auto-scroll Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let scrollTimeout;
                
                function startAutoScroll() {
                    scrollTimeout = setInterval(() => {
                        // Simulate next button click every 5 seconds
                        document.querySelector('[wire\\:click="nextSlide"]')?.click();
                    }, 5000);
                }

                // Listen for reset event
                Livewire.on('reset-carousel-timer', () => {
                    clearInterval(scrollTimeout);
                    startAutoScroll();
                });

                // Start auto-scroll on component load
                startAutoScroll();
            });
        </script>
    @else
        <div class="p-12 text-center text-gray-400">
            <p>No courses available</p>
        </div>
    @endif
</div>
