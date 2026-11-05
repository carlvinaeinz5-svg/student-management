<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->course_code }} — {{ $course->title }}
            </h2>
            <a href="{{ route('courses.index') }}" class="text-sm text-indigo-600">
                Back to courses
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <p>
                    <span class="font-semibold">Lecturer:</span>
                    @if ($course->lecturer)
                        {{ $course->lecturer->name }}
                    @else
                        Unassigned
                    @endif
                </p>
                <p class="mt-2">
                    <span class="font-semibold">Enrolled students:</span>
                    {{ $course->students->count() }}
                </p>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-semibold">Enrolled students</h3>
                    <ul class="divide-y divide-gray-100">
                        @forelse ($course->students as $student)
                            <li class="py-3">
                                {{ $student->name }}
                                <span class="text-gray-500">{{ $student->email }}</span>
                            </li>
                        @empty
                            <li class="py-3 text-gray-500">No students enrolled yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
