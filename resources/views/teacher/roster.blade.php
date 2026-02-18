<x-layouts.app>

<h1 class="text-2xl font-bold mb-4">Student Roster — {{ $course->title }}</h1>

<div class="card bg-base-100 p-4">
    <ul class="divide-y">
        @foreach($course->students as $student)
            <li class="py-2 flex justify-between items-center">
                <div>
                    <div class="font-medium">{{ $student->name }}</div>
                    <div class="text-sm text-gray-500">{{ $student->email }}</div>
                </div>
                <div class="text-sm text-gray-500">Enrolled at: {{ $student->pivot->created_at ?? '' }}</div>
            </li>
        @endforeach
    </ul>
</div>

</x-layouts.app>
