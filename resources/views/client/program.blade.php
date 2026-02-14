<x-client-layout>
    <x-slot:title>My Program</x-slot:title>

    <div class="space-y-6">
        @if ($isFinished)
            <div class="rounded-2xl border border-slate-800 bg-slate-900/50 p-8 text-center">
                <p class="text-sm text-slate-400">You have completed your program. Thank you for your dedication.</p>
            </div>
        @else
            <section>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-50">{{ $program->name }}</h1>
                @if ($program->description)
                    <p class="text-sm text-slate-400 mt-1">{{ $program->description }}</p>
                @endif
                @if ($program->duration_weeks)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $program->duration_weeks }}-week program</p>
                @endif
            </section>

            <section class="space-y-6">
                @foreach ($program->workouts as $workout)
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/50 p-5 sm:p-6">
                        <h2 class="text-base font-semibold text-slate-50 mb-4">{{ $workout->name }}</h2>
                        <ul class="space-y-3">
                            @foreach ($workout->exercises as $exercise)
                                <li class="flex items-start gap-3 py-2 border-b border-slate-800/80 last:border-0">
                                    <span
                                        class="shrink-0 flex size-6 items-center justify-center rounded-full bg-emerald-500/20 text-xs font-medium text-emerald-300">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <span class="text-sm text-slate-200">{{ $exercise->name }}</span>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            @if ($exercise->sets)
                                                {{ $exercise->sets }} sets
                                            @endif
                                            @if ($exercise->reps)
                                                @if ($exercise->sets)
                                                    ·
                                                @endif
                                                {{ $exercise->reps }} reps
                                            @endif
                                            @if ($exercise->rest_seconds)
                                                · {{ $exercise->rest_seconds }}s rest
                                            @endif
                                        </p>
                                        @if ($exercise->notes)
                                            <p class="text-xs text-slate-400 mt-0.5 italic">{{ $exercise->notes }}</p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if ($workout->exercises->isEmpty())
                            <p class="text-xs text-slate-500 italic">No exercises yet.</p>
                        @endif
                    </div>
                @endforeach
            </section>

            @if ($program->workouts->isEmpty())
                <div class="rounded-2xl border border-slate-800 bg-slate-900/50 p-8 text-center">
                    <p class="text-sm text-slate-400">Your coach is still building your program. Check back soon.</p>
                </div>
            @endif
        @endif
    </div>
</x-client-layout>
