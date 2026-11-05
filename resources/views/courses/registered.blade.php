<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My courses
            </h2>
            <a href="{{ route('courses.available') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                Browse available courses
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto p-6">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Course title</th>
                                <th class="px-4 py-3">Lecturer</th>
                                <th class="px-4 py-3">Registered</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($courses as $course)
                                <tr>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $course->course_code }}
                                    </td>
                                    <td class="px-4 py-3">{{ $course->title }}</td>
                                    <td class="px-4 py-3">
                                        @if ($course->lecturer)
                                            {{ $course->lecturer->name }}
                                        @else
                                            To be assigned
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($course->pivot->created_at)
                                            {{ $course->pivot->created_at->format('M j, Y') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <form
                                            method="POST"
                                            action="{{ route('courses.unregister', $course) }}"
                                            onsubmit="return confirm('Drop this course?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Drop course
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                        You haven’t registered for any courses yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $courses->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
