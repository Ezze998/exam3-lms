<div class="space-y-4">

<input wire:model="title" placeholder="Title" class="input input-bordered w-full">
<input wire:model="video_url" placeholder="Video URL" class="input input-bordered w-full">
<input wire:model="order" type="number" placeholder="Order" class="input input-bordered w-full">

<button wire:click="save" class="btn btn-primary w-full">
    Save Lesson
</button>

</div>
