<x-coach-layout>
    <x-slot:title>{{ $program->name }}</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('coach.programs') }}"
                    class="text-xs text-slate-400 hover:text-slate-50 transition-colors flex items-center gap-1 mb-2">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to programs
                </a>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-50">{{ $program->name }}</h1>
                @if ($program->description)
                    <p class="text-sm text-slate-400 mt-1">{{ $program->description }}</p>
                @endif
                @if ($program->duration_weeks)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $program->duration_weeks }} weeks</p>
                @endif
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <a href="{{ route('coach.programs.edit', $program) }}"
                    class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                    Edit program
                </a>
                <form action="{{ route('coach.programs.destroy', $program) }}" method="post" class="inline"
                    onsubmit="return confirm('Delete this program?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex cursor-pointer items-center rounded-full border border-red-500/50 px-3 py-1.5 text-xs font-medium text-red-400 hover:border-red-400 hover:text-red-300 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <section class="space-y-6">
            @foreach ($program->workouts as $workout)
                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 sm:p-5">
                    @php($isEditing = $workout->id === session('workout_edit_id'))
                    <div class="mb-4" data-workout-edit-container data-workout-name="{{ e($workout->name) }}">
                        {{-- View state --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 {{ $isEditing ? 'hidden' : '' }}"
                            data-workout-view>
                            <h3 class="text-base font-semibold text-slate-50">{{ $workout->name }}</h3>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" data-workout-edit-trigger
                                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors cursor-pointer">
                                    Edit
                                </button>
                                <form action="{{ route('coach.programs.workouts.destroy', [$program, $workout]) }}"
                                    method="post" class="inline" onsubmit="return confirm('Remove this workout?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-full border border-red-500/50 px-3 py-1.5 text-xs font-medium text-red-400 hover:border-red-400 hover:text-red-300 transition-colors cursor-pointer">
                                        Remove workout
                                    </button>
                                </form>
                            </div>
                        </div>
                        {{-- Edit state --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 {{ $isEditing ? '' : 'hidden' }}"
                            data-workout-edit>
                            <form id="workout-update-{{ $workout->id }}"
                                action="{{ route('coach.programs.workouts.update', [$program, $workout]) }}"
                                method="post" class="flex-1 min-w-0">
                                @csrf
                                @method('PUT')
                                <div>
                                    <input type="text" name="name" value="{{ $isEditing ? old('name', $workout->name) : $workout->name }}" required
                                        class="w-full max-w-md rounded-lg border {{ $isEditing && $errors->has('name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-2.5 py-1.5 text-sm font-semibold text-slate-50 focus:border-emerald-500 focus:outline-none">
                                    @if ($isEditing && $errors->has('name'))
                                        <p class="text-xs text-red-400 mt-1">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </form>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="submit" form="workout-update-{{ $workout->id }}"
                                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors cursor-pointer">
                                    Save
                                </button>
                                <button type="button" data-workout-cancel
                                    class="inline-flex items-center justify-center rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors cursor-pointer">
                                    Cancel
                                </button>
                                <form action="{{ route('coach.programs.workouts.destroy', [$program, $workout]) }}"
                                    method="post" class="inline" onsubmit="return confirm('Remove this workout?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-full border border-red-500/50 px-3 py-1.5 text-xs font-medium text-red-400 hover:border-red-400 hover:text-red-300 transition-colors cursor-pointer">
                                        Remove workout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if ($workout->exercises->isNotEmpty())
                        <ul class="space-y-2 mb-4">
                            @foreach ($workout->exercises as $exercise)
                                <li class="flex items-center justify-between gap-4 py-2 border-b border-slate-800/80 last:border-0">
                                    <div>
                                        <span class="text-sm text-slate-200">{{ $exercise->name }}</span>
                                        <span class="text-xs text-slate-500 ml-2">
                                            @if ($exercise->sets)
                                                {{ $exercise->sets }}×
                                            @endif
                                            {{ $exercise->reps ?? '—' }}
                                            @if ($exercise->rest_seconds)
                                                · {{ $exercise->rest_seconds }}s rest
                                            @endif
                                            @if ($exercise->notes)
                                                · {{ Str::limit($exercise->notes, 40) }}
                                            @endif
                                        </span>
                                    </div>
                                    <form
                                        action="{{ route('coach.workouts.exercises.destroy', [$workout, $exercise]) }}"
                                        method="post" class="inline" onsubmit="return confirm('Remove this exercise?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-slate-400 hover:text-red-400 cursor-pointer">Remove</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <form action="{{ route('coach.workouts.exercises.store', $workout) }}" method="post"
                        class="flex flex-wrap items-center gap-3 p-3 rounded-lg bg-slate-900/60 border border-slate-800">
                        @csrf
                        <input type="hidden" name="workout_id" value="{{ $workout->id }}">
                        <div class="flex-1 min-w-[120px]">
                            <label for="ex-name-{{ $workout->id }}" class="sr-only">Exercise name</label>
                            <input type="text" name="name" id="ex-name-{{ $workout->id }}" placeholder="Exercise name"
                                required
                                class="w-full rounded-lg border border-slate-700 bg-slate-950/80 px-2.5 py-1.5 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none">
                        </div>
                        <div class="w-16">
                            <label for="ex-sets-{{ $workout->id }}" class="sr-only">Sets</label>
                            <input type="number" name="sets" id="ex-sets-{{ $workout->id }}" placeholder="Sets"
                                min="1" max="20"
                                class="w-full rounded-lg border border-slate-700 bg-slate-950/80 px-2.5 py-1.5 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none">
                        </div>
                        <div class="w-20">
                            <label for="ex-reps-{{ $workout->id }}" class="sr-only">Reps</label>
                            <input type="text" name="reps" id="ex-reps-{{ $workout->id }}"
                                placeholder="8-10" maxlength="50"
                                class="w-full rounded-lg border border-slate-700 bg-slate-950/80 px-2.5 py-1.5 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none">
                        </div>
                        <button type="submit"
                            class="shrink-0 rounded-lg border border-emerald-500/50 bg-emerald-500/20 px-3 py-1.5 text-sm font-medium text-emerald-300 hover:bg-emerald-500/30 hover:border-emerald-500/70 transition-colors cursor-pointer">
                            Add exercise
                        </button>
                    </form>
                </div>
            @endforeach

            <form action="{{ route('coach.programs.workouts.store', $program) }}" method="post"
                class="rounded-xl border border-dashed border-slate-700 bg-slate-900/30 p-4 flex items-center gap-4">
                @csrf
                <div class="flex-1 min-w-[180px]">
                    <label for="workout-name" class="sr-only">Workout name</label>
                    <input type="text" name="workout_name" id="workout-name" placeholder="e.g. Upper Body, Day 1"
                        value="{{ old('workout_name') }}" required
                        class="w-full rounded-lg border {{ $errors->has('workout_name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/80 px-3 py-2 text-sm text-slate-50 placeholder:text-slate-500 focus:border-emerald-500 focus:outline-none">
                    @error('workout_name')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="shrink-0 inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                    Add workout
                </button>
            </form>
        </section>
    </div>
</x-coach-layout>
