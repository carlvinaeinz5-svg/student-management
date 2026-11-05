<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Available courses
            </h2>
            <a href="{{ route('courses.registered') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                My courses
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

            <form
                method="GET"
                action="{{ route('courses.available') }}"
                class="flex flex-wrap gap-2"
            >
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search code, title, or lecturer"
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
                        href="{{ route('courses.available') }}"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700"
                    >
                        Clear
                    </a>
                @endif
            </form>

            <div class="grid gap-4 md:grid-cols-2">
                @forelse ($courses as $course)
                    <article class="course-card rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-xs font-semibold uppercase text-gray-500">
                            {{ $course->course_code }}
                        </p>
                        <h3 class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $course->title }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Lecturer:
                            @if ($course->lecturer)
                                {{ $course->lecturer->name }}
                            @else
                                To be assigned
                            @endif
                        </p>

                        @if (in_array($course->id, $registeredCourseIds, true))
                            <p class="mt-4 text-sm font-medium text-green-700">
                                You are registered
                            </p>
                        @else
                            <form
                                class="mt-4"
                                method="POST"
                                action="{{ route('courses.register', $course) }}"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="rounded-md bg-green-700 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-green-800"
                                >
                                    Register for course
                                </button>
                            </form>
                        @endif
                    </article>
                @empty
                    <div class="rounded-lg bg-white p-6 text-gray-500">
                        No courses are available.
                    </div>
                @endforelse
            </div>

            <div>{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>
