<div>
    <label for="course_code" class="block text-sm font-medium text-gray-700">
        Course code
    </label>
    <input
        id="course_code"
        name="course_code"
        type="text"
        value="{{ old('course_code', $course->course_code) }}"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
    >

    @error('course_code')
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="title" class="block text-sm font-medium text-gray-700">
        Course title
    </label>
    <input
        id="title"
        name="title"
        type="text"
        value="{{ old('title', $course->title) }}"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
    >

    @error('title')
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="lecturer_id" class="block text-sm font-medium text-gray-700">
        Lecturer
    </label>
    <select
        id="lecturer_id"
        name="lecturer_id"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
    >
        <option value="">Unassigned</option>

        @foreach ($lecturers as $lecturer)
            <option value="{{ $lecturer->id }}"
                @if ((string) old('lecturer_id', $course->lecturer_id) === (string) $lecturer->id)
                    selected
                @endif
            >
                {{ $lecturer->name }} ({{ $lecturer->email }})
            </option>
        @endforeach
    </select>

    @error('lecturer_id')
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center gap-3">
    <button
        type="submit"
        class="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase
         tracking-widest text-white hover:bg-gray-700"
    >
        {{ $buttonLabel }}
    </button>
    <a href="{{ route('courses.index') }}" class="text-sm text-gray-600">
        Cancel
    </a>
</div>
