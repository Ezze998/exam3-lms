<div class="space-y-4">

<h2 class="text-xl font-bold">Create Course</h2>

<input
    wire:model="title"
    placeholder="Course title"
    class="input input-bordered w-full">

<textarea
    wire:model="description"
    placeholder="Description"
    class="textarea textarea-bordered w-full"></textarea>

<input
    type="file"
    wire:model="thumbnail"
    class="file-input file-input-bordered w-full">

<button
    wire:click="save"
    class="btn btn-primary w-full">
    Save Course
</button>

</div>
