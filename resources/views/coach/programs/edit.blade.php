<x-coach-layout>
    <x-slot:title>Edit {{ $program->name }}</x-slot:title>

    <div class="space-y-8">
        <section>
            <a href="{{ route('coach.programs.show', $program) }}"
                class="text-xs text-slate-400 hover:text-slate-50 transition-colors flex items-center gap-1 mb-2">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to program
            </a>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Edit program</h1>
            <p class="text-sm text-slate-400">Update program details.</p>
        </section>

        <form class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6 space-y-5" method="post"
            action="{{ route('coach.programs.update', $program) }}">
            @csrf
            @method('PUT')
            @if ($errors->isNotEmpty())
                <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                    Please fix the errors below.
                </p>
            @endif

            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-200">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}"
                    class="w-full rounded-lg border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                @error('name')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-slate-200">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-lg border {{ $errors->has('description') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-y">{{ old('description', $program->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="duration_weeks" class="block text-sm font-medium text-slate-200">Duration (weeks)</label>
                <input type="number" name="duration_weeks" id="duration_weeks" min="1" max="52"
                    value="{{ old('duration_weeks', $program->duration_weeks) }}"
                    class="w-full rounded-lg border {{ $errors->has('duration_weeks') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                @error('duration_weeks')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                    Save changes
                </button>
                <a href="{{ route('coach.programs.show', $program) }}"
                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-coach-layout>
