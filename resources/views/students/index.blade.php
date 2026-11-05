<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Students
            </h2>
            <a
                href="{{ route('students.create') }}"
                class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700"
            >
                Add student
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
                    <form
                        method="GET"
                        action="{{ route('students.index') }}"
                        class="mb-5 flex flex-wrap gap-2"
                    >
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by name or email"
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
                                href="{{ route('students.index') }}"
                                class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700"
                            >
                                Clear
                            </a>
                        @endif
                    </form>

                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Registered</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($students as $student)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $student->email }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $student->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a
                                                class="text-indigo-600 hover:text-indigo-900"
                                                href="{{ route('students.show', $student) }}"
                                            >
                                                View
                                            </a>
                                            <a
                                                class="text-indigo-600 hover:text-indigo-900"
                                                href="{{ route('students.edit', $student) }}"
                                            >
                                                Edit
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route('students.destroy', $student) }}"
                                                onsubmit="return confirm('Delete this student?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-600 hover:text-red-900"
                                                    type="submit"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        No students yet. Add the first student to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $students->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
