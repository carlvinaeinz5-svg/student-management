<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add student
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('students.store') }}" class="space-y-5">
                    @csrf
                    @include('students.partials.form', [
                        'buttonLabel' => 'Create student',
                        'isEditing' => false,
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
