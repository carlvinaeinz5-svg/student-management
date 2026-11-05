<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div>
                <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}.</p>
            </div>

            <div class="dashboard-summary grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($summary as $label => $value)
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Quick links</h3>
                <div class="mt-4 flex flex-wrap gap-3">
                    @if (Auth::user()->hasRole('Admin'))
                        <a href="{{ route('students.index') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Manage students</a>
                        <a href="{{ route('courses.index') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Manage courses</a>
                    @elseif (Auth::user()->hasRole('Lecturer'))
                        <a href="{{ route('courses.my-courses') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">View my courses</a>
                    @else
                        <a href="{{ route('courses.available') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Browse courses</a>
                        <a href="{{ route('courses.registered') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">View my courses</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
