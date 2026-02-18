<div class="space-y-4">

<h2 class="text-xl font-bold">Create Course</h2>

<input
    wire:model="title"
    placeholder="Course title"
    class="input input-bordered w-full">
@error('title')<div class="text-sm text-error">{{ $message }}</div>@enderror

<textarea
    wire:model="description"
    placeholder="Description"
    class="textarea textarea-bordered w-full"></textarea>
@error('description')<div class="text-sm text-error">{{ $message }}</div>@enderror

<input
    type="file"
    wire:model="thumbnail"
    class="file-input file-input-bordered w-full">
@error('thumbnail')<div class="text-sm text-error">{{ $message }}</div>@enderror

<button
    type="button"
    wire:click="save"
    class="btn btn-primary w-full">
    Save Course
</button>

</div>
