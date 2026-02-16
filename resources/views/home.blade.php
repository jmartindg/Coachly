<x-layout>
    @php($programs = \App\Models\User::workoutStyleOptions())
    <div class="grid gap-10 lg:gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)] items-center">
        <section>
            <div
                class="inline-flex items-center gap-2 rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-xs text-emerald-300 mb-4">
                <span
                    class="flex h-4 w-4 items-center justify-center rounded-full bg-emerald-500/30 text-[0.6rem]">★</span>
                1:1 Online Coaching • Tailored To You
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-slate-50 mb-3 leading-tight">
                Get stronger, feel better,<br class="hidden sm:block">
                <span class="text-emerald-400">stay consistent</span>.
            </h1>

            <p class="text-sm sm:text-base text-slate-300 max-w-xl mb-6">
                Personalized strength, nutrition, and habit coaching for busy professionals who want real results
                without burning out on restrictive plans or endless cardio.
            </p>

            <div class="flex flex-wrap items-center gap-3 mb-8">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-slate-950 shadow-lg shadow-emerald-500/40 hover:bg-emerald-400 transition-colors">
                    Apply for coaching
                </a>

                <button type="button"
                    class="inline-flex items-center justify-center rounded-full border border-slate-600/70 px-4 py-2 text-xs sm:text-sm font-medium text-slate-100 hover:border-slate-300 hover:text-slate-50 transition-colors">
                    Book a free 15-min call
                </button>
            </div>

            <div class="flex flex-wrap gap-6 text-xs sm:text-sm text-slate-300">
                <div>
                    <div class="text-lg font-semibold text-slate-50">150+</div>
                    <p class="text-slate-400">Lives coached</p>
                </div>
                <div>
                    <div class="text-lg font-semibold text-slate-50">12+</div>
                    <p class="text-slate-400">Years experience</p>
                </div>
                <div>
                    <div class="text-lg font-semibold text-slate-50">90%</div>
                    <p class="text-slate-400">6-month adherence</p>
                </div>
            </div>

        </section>

        <aside class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 lg:p-6 shadow-2xl shadow-slate-950/70">
            <div class="space-y-5">
                <div class="space-y-2">
                    <p class="text-[0.75rem] uppercase tracking-[0.15em] text-slate-400">What you get</p>
                    <h2 class="text-xl font-semibold tracking-tight text-slate-50">A clear plan that fits your real life.</h2>
                    <p class="text-sm text-slate-300">
                        Coaching is designed to remove guesswork. You get practical training and nutrition support you
                        can actually stick with.
                    </p>
                </div>

                <div class="space-y-3">
                    @foreach ($programs as $program)
                        <div class="rounded-xl border border-slate-700/80 bg-slate-900/80 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-300">
                                {{ $program['label'] }}
                            </p>
                            <p class="text-sm text-slate-200 mt-1">{{ $program['description'] }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $program['subtitle'] }}</p>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('programs') }}"
                    class="inline-flex w-full items-center justify-center rounded-full border border-slate-600/70 px-4 py-2.5 text-sm font-medium text-slate-100 hover:border-slate-300 hover:text-slate-50 transition-colors">
                    Compare coaching programs
                </a>
            </div>
        </aside>
    </div>
</x-layout>
