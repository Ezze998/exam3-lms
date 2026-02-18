<div class="space-y-6">

    <h2 class="text-2xl font-bold">{{ $course->title }}</h2>

    <div class="card bg-base-100 p-6">
        <h3 class="text-xl font-semibold">{{ $lesson->title }}</h3>

        <div class="mt-4">
            {{-- if content is a URL, embed; otherwise show text --}}
            @if(\Illuminate\Support\Str::startsWith($lesson->content, ['http://','https://']))
                <iframe width="100%" height="480" src="{{ $lesson->content }}" frameborder="0" allowfullscreen></iframe>
            @else
                <div class="prose">
                    {!! nl2br(e($lesson->content)) !!}
                </div>
            @endif
        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="prev" class="btn">Previous</button>
            <div class="flex items-center gap-3">
                @if($isCompleted)
                    <span class="text-sm text-success">Completed ✓</span>
                @else
                    <button wire:click="markComplete" class="btn btn-success">Mark Complete</button>
                @endif
                <button wire:click="next" class="btn btn-primary">Next</button>
            </div>
        </div>
    </div>

</div>
