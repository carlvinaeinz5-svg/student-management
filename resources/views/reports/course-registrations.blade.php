<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Course registration report
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="dashboard-summary grid gap-4 sm:grid-cols-3">
                @foreach ($summary as $label => $value)
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto p-6">
                    <form
                        method="GET"
                        action="{{ route('reports.course-registrations') }}"
                        class="mb-5 flex flex-wrap gap-2"
                    >
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search course, student, or lecturer"
                            class="min-w-64 rounded-md border-gray-300 shadow-sm"
                        >
                        <button
                            type="submit"
                            class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700"
                        >
                            Search
                        </button>

                        @if ($search !== '')
                            <a
                                href="{{ route('reports.course-registrations') }}"
                                class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700"
                            >
                                Clear
                            </a>
                        @endif
                    </form>

                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Course</th>
                                <th class="px-4 py-3">Student</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Lecturer</th>
                                <th class="px-4 py-3">Registered</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($registrations as $registration)
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="font-medium">
                                            {{ $registration->course->course_code }}
                                        </span>
                                        <br>
                                        <span class="text-gray-500">
                                            {{ $registration->course->title }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $registration->student->name }}</td>
                                    <td class="px-4 py-3">{{ $registration->student->email }}</td>
                                    <td class="px-4 py-3">
                                        @if ($registration->course->lecturer)
                                            {{ $registration->course->lecturer->name }}
                                        @else
                                            Unassigned
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $registration->created_at->format('M j, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                        No registrations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $registrations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
