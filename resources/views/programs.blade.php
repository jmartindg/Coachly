<x-layout>
    <x-slot:title>Programs</x-slot:title>
    @php($programs = \App\Models\User::workoutStyleOptions())
    <div class="w-full space-y-10">
        <section class="space-y-3">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-300/80">
                Programs
            </p>
            <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-50">
                Coaching options built around your schedule.
            </h1>
            <p class="text-sm sm:text-base text-slate-300 max-w-2xl">
                Every program includes personalized strength training, flexible nutrition guidance, and weekly
                check-ins—so you always know exactly what to do when you walk into the gym or kitchen.
            </p>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            @foreach ($programs as $key => $program)
                @php($isMostPopular = $program['is_most_popular'] ?? false)
                <article
                    class="rounded-2xl {{ $isMostPopular ? 'border border-emerald-500/70 bg-slate-900/70 shadow-lg shadow-emerald-500/20 relative' : 'border border-slate-800 bg-slate-900/50' }} p-5 sm:p-6 flex flex-col">
                    @if ($isMostPopular)
                        <span
                            class="absolute -top-3 right-4 inline-flex items-center rounded-full bg-emerald-500 px-3 py-1 text-[0.65rem] font-semibold text-slate-950 shadow-md shadow-emerald-500/40">
                            Most popular
                        </span>
                    @endif
                    <h2 class="text-sm font-semibold text-slate-50 mb-1">{{ $program['label'] }}</h2>
                    <p class="text-xs text-slate-400 mb-4">{{ $program['subtitle'] }}</p>
                    <p class="text-xs {{ $isMostPopular ? 'text-slate-200' : 'text-slate-300' }} mb-4">
                        {{ $program['description'] }}
                    </p>
                    <ul class="space-y-2 text-xs {{ $isMostPopular ? 'text-slate-200' : 'text-slate-300' }} mb-4">
                        @foreach ($program['bullets'] as $bullet)
                            <li>• {{ $bullet }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-auto text-[0.7rem] {{ $isMostPopular ? 'text-slate-200' : 'text-slate-400' }}">
                        {{ $program['hint'] }}
                    </p>
                </article>
            @endforeach
        </section>

        <section
            class="rounded-2xl border border-slate-800 bg-slate-900/40 p-5 sm:p-6 space-y-4 text-xs text-slate-300">
            <h2 class="text-sm font-semibold text-slate-50">How to choose a program</h2>
            <p>
                Not sure which path makes the most sense? Start with 1:1 Online Coaching—we can always shift you into
                Foundations or Hybrid later once we understand your schedule, training history, and goals.
            </p>
            <a href="/contact"
                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-xs sm:text-sm font-semibold text-slate-950 shadow-md shadow-emerald-500/30 hover:bg-emerald-400 transition-colors">
                Ask which program is right for you
            </a>
        </section>
    </div>
</x-layout>
