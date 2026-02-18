<div class="space-y-4">

<h2 class="text-xl font-bold">Add Lesson</h2>

<input wire:model="title" placeholder="Lesson title" class="input input-bordered w-full">

<input wire:model="video_url" placeholder="Video URL" class="input input-bordered w-full">

<input wire:model="order" type="number" placeholder="Order" class="input input-bordered w-full">

<button wire:click="save" class="btn btn-primary w-full">Save Lesson</button>

</div>
