<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->course_code }} — {{ $course->title }}
            </h2>
            <a href="{{ route('courses.my-courses') }}" class="text-sm text-indigo-600">
                Back to my courses
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
