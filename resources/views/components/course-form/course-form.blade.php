<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold text-amber-900 mb-6">{{ isset($course) ? 'Edit Course' : 'Create Course' }}</h2>

    <!-- Title Input -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-amber-900 mb-2">Course Title</label>
        <input
            type="text"
            wire:model="title"
            placeholder="Enter course title"
            class="w-full px-4 py-2 rounded-lg border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent">
        @error('title')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <!-- Description Input -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-amber-900 mb-2">Description</label>
        <textarea
            wire:model="description"
            placeholder="Enter course description"
            rows="5"
            class="w-full px-4 py-2 rounded-lg border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-600 focus:border-transparent"></textarea>
        @error('description')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <!-- Thumbnail Upload -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-amber-900 mb-2">Course Thumbnail</label>
        <div class="border-2 border-dashed border-amber-300 rounded-lg p-6 cursor-pointer hover:bg-amber-50">
            <input
                type="file"
                wire:model="thumbnail"
                class="w-full file-input file-input-bordered">
            <p class="text-sm text-amber-600 mt-2">Supported formats: JPG, PNG (Max 2MB)</p>
        </div>
        @error('thumbnail')<div class="text-sm text-red-600 mt-1">{{ $message }}</div>@enderror
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3">
        <button
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            class="flex-1 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium py-3 rounded-lg transition-all duration-200 transform hover:scale-105 disabled:opacity-50">
            <span wire:loading.remove>Save Course</span>
            <span wire:loading>Saving...</span>
        </button>
        <a href="/teacher/dashboard" class="flex-1 text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 rounded-lg transition-all duration-200">
            Cancel
        </a>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="mt-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
            {{ session('warning') }}
        </div>
    @endif
</div>
