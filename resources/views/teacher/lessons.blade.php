<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-b from-[#fdebd0] to-white">
        <div class="max-w-5xl mx-auto px-6 py-12">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-12">
                <div>
                    <a href="/courses/{{ $course->id }}" class="text-sm text-gray-600 hover:text-[#8b3f2f] inline-flex items-center gap-1 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Course
                    </a>
                    <h1 class="text-4xl font-bold text-[#8b3f2f]">Manage Lessons</h1>
                    <p class="text-gray-600 mt-2">{{ $course->title }}</p>
                </div>

                <a href="#lesson-form" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Lesson
                </a>
            </div>

            {{-- Lessons List --}}
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-[#8b3f2f] mb-6">Lessons ({{ $course->lessons->count() }})</h2>

                @if($course->lessons->count() > 0)
                    <div class="space-y-3">
                        @foreach($course->lessons as $lesson)
                            <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between hover:shadow-md transition">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-[#fdebd0] flex items-center justify-center text-[#8b3f2f] font-semibold">
                                            {{ $loop->index + 1 }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-semibold text-[#8b3f2f]">{{ $lesson->title }}</h3>
                                                <span class="badge @if($lesson->status === 'published') badge-success @else badge-outline @endif text-xs">
                                                    {{ ucfirst($lesson->status) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($lesson->content ?? '', 100) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 ml-4">
                                    <a href="{{ route('teacher.lesson.edit', [$course->id, $lesson->id]) }}" 
                                       class="btn btn-sm btn-ghost">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="/teacher/lessons/{{ $lesson->id }}/delete" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this lesson?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost text-error">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-lg shadow">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">No lessons yet</p>
                        <p class="text-gray-400 text-sm mt-2">Create your first lesson to get started</p>
                    </div>
                @endif
            </div>

            {{-- Lesson Form --}}
            <div class="bg-white rounded-lg shadow p-8" id="lesson-form">
                <h2 class="text-2xl font-bold text-[#8b3f2f] mb-6">
                    @if(isset($lesson))
                        Edit Lesson
                    @else
                        Add New Lesson
                    @endif
                </h2>

                <form id="lesson-form-element" 
                      action="{{ isset($lesson) ? route('teacher.lessons.update', $lesson->id) : '/teacher/lessons' }}" 
                      method="POST" 
                      class="space-y-6">
                    @csrf
                    @if(isset($lesson))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" id="action-type" name="action_type" value="">

                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Lesson Title</span>
                        </label>
                        <input type="text" name="title" id="lesson-title" placeholder="Enter lesson title" 
                               class="input input-bordered w-full @error('title') input-error @enderror"
                               value="{{ old('title', $lesson->title ?? '') }}" required>
                        @error('title')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Lesson Content</span>
                        </label>
                        <textarea id="lesson-content" name="content" placeholder="Enter lesson content"
                                  class="w-full h-96 @error('content') border-error @enderror" required>{{ old('content', $lesson->content ?? '') }}</textarea>
                        @error('content')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t">
                        <button type="button" onclick="submitForm('draft')" class="btn btn-outline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            @if(isset($lesson))
                                Save as Draft
                            @else
                                Save as Draft
                            @endif
                        </button>
                        <button type="button" onclick="submitForm('publish')" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @if(isset($lesson))
                                Update & Publish
                            @else
                                Publish Lesson
                            @endif
                        </button>
                        <a href="/courses/{{ $course->id }}" class="btn btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>

            {{-- TinyMCE Script --}}
            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                tinymce.init({
                    selector: '#lesson-content',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                    height: 500,
                    menubar: true,
                    statusbar: true,
                    branding: false,
                    promotion: false,
                    content_style: 'body { font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif; font-size:14px; }',
                    setup: function(editor) {
                        editor.on('change', function() {
                            tinymce.triggerSave();
                        });
                        
                        // Pre-populate content when editing
                        @if(isset($lesson))
                            editor.on('init', function() {
                                editor.setContent(`{{ $lesson->content }}`);
                            });
                        @endif
                    }
                });

                function submitForm(action) {
                    // Save TinyMCE content to textarea
                    tinymce.triggerSave();
                    
                    // Set the action type
                    document.getElementById('action-type').value = action;
                    
                    // Submit the form
                    document.getElementById('lesson-form-element').submit();
                }
            </script>

        </div>
    </div>
</x-layouts.app>
