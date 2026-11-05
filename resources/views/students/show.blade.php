<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Student details
            </h2>
            <a href="{{ route('students.index') }}" class="text-sm text-indigo-600">
                Back to students
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="rounded-lg bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $student->name }}
                        </h3>
                        <p class="mt-1 text-gray-600">{{ $student->email }}</p>
                    </div>
                    <a
                        href="{{ route('students.edit', $student) }}"
                        class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700"
                    >
                        Edit student
                    </a>
                </div>
            </section>

            <section class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto p-6">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">
                        Registered courses
                    </h3>

                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Course title</th>
                                <th class="px-4 py-3">Lecturer</th>
                                <th class="px-4 py-3">Registered</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($student->courses as $course)
                                <tr>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $course->course_code }}
                                    </td>
                                    <td class="px-4 py-3">{{ $course->title }}</td>
                                    <td class="px-4 py-3">
                                        @if ($course->lecturer)
                                            {{ $course->lecturer->name }}
                                        @else
                                            Unassigned
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($course->pivot->created_at)
                                            {{ $course->pivot->created_at->format('M j, Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        This student has not registered for any courses yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
