<div>
    <label for="name" class="block text-sm font-medium text-gray-700">
        Full name
    </label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $student->name) }}"
        required
        autocomplete="name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >

    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="email" class="block text-sm font-medium text-gray-700">
        Email address
    </label>
    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $student->email) }}"
        required
        autocomplete="email"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >

    @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password" class="block text-sm font-medium text-gray-700">
        @if ($isEditing)
            New password (leave blank to keep current)
        @else
            Password
        @endif
    </label>
    <input
        id="password"
        name="password"
        type="password"
        @if (! $isEditing)
            required
        @endif
        autocomplete="new-password"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >

    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
        Confirm password
    </label>
    <input
        id="password_confirmation"
        name="password_confirmation"
        type="password"
        autocomplete="new-password"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
</div>

<div class="flex items-center gap-3">
    <button
        type="submit"
        class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700"
    >
        {{ $buttonLabel }}
    </button>
    <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
        Cancel
    </a>
</div>
