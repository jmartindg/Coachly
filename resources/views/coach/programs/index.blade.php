<x-coach-layout>
    <x-slot:title>Programs</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Programs</h1>
                <p class="text-sm text-slate-400">Create and manage training programs for your clients.</p>
            </div>
            <a href="{{ route('coach.programs.create') }}"
                class="shrink-0 inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                New program
            </a>
        </section>

        @if ($programs->isNotEmpty())
            <ul class="space-y-3">
                @foreach ($programs as $program)
                    <li
                        class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-slate-50">{{ $program->name }}</h3>
                            @if ($program->description)
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{{ $program->description }}</p>
                            @endif
                            <p class="text-xs text-slate-500 mt-1">
                                {{ $program->workouts_count }} workout{{ $program->workouts_count === 1 ? '' : 's' }}
                                @if ($program->duration_weeks)
                                    · {{ $program->duration_weeks }} weeks
                                @endif
                            </p>
                        </div>
                        <div class="shrink-0 flex items-center gap-3">
                            <a href="{{ route('coach.programs.show', $program) }}"
                                class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                                View
                            </a>
                            <a href="{{ route('coach.programs.edit', $program) }}"
                                class="text-xs text-slate-400 hover:text-slate-50 py-1">Edit</a>
                            <form action="{{ route('coach.programs.destroy', $program) }}" method="post"
                                class="inline" onsubmit="return confirm('Delete this program?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-red-400 bg-red-500/10 px-2 py-1 rounded-full hover:text-red-300 cursor-pointer">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-8 text-center">
                <p class="text-sm text-slate-400">No programs yet. Create your first program to assign to clients.</p>
                <a href="{{ route('coach.programs.create') }}"
                    class="mt-4 inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                    New program
                </a>
            </div>
        @endif
    </div>
</x-coach-layout>
