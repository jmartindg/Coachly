<x-layout>
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

            <section id="programs" class="mt-10 space-y-4">
                <h2 class="text-base sm:text-lg font-semibold text-slate-50">Coaching programs</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-300 mb-1">1:1 Online
                            Coaching</p>
                        <p class="text-sm text-slate-200 mb-2">Fully customized training, nutrition, and weekly
                            check-ins.</p>
                        <p class="text-xs text-slate-400">Perfect if you want hands-on guidance and accountability.</p>
                    </div>
                    <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-300 mb-1">Hybrid Coaching
                        </p>
                        <p class="text-sm text-slate-200 mb-2">In-gym sessions plus online support between workouts.</p>
                        <p class="text-xs text-slate-400">Best for lifters who like in-person form checks.</p>
                    </div>
                </div>
            </section>
        </section>

        <aside
            class="relative rounded-2xl border border-slate-800 bg-slate-900/60 p-5 lg:p-6 shadow-2xl shadow-slate-950/70">
            <div
                class="absolute right-4 top-4 inline-flex items-center gap-2 rounded-full border border-slate-700/70 bg-slate-950/80 px-3 py-1 text-[0.7rem] text-slate-300">
                <span class="h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_0_4px] shadow-emerald-400/30"></span>
                Next intake opens Monday
            </div>

            <p class="text-[0.75rem] uppercase tracking-[0.15em] text-slate-400 mb-2">
                Sample weekly check-in
            </p>

            <p class="text-sm text-slate-100 mb-4">
                “Down 8 lbs, sleeping better, and my back pain is
                <span class="text-emerald-300 font-medium">finally gone</span>. Hit every workout this week.”
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-200 mb-5">
                <div
                    class="flex items-center justify-between gap-2 rounded-xl border border-slate-700/70 bg-slate-900/80 px-3 py-2">
                    <div>
                        <p class="text-[0.75rem] font-semibold text-slate-50">Training</p>
                        <p class="text-[0.7rem] text-slate-400">3x strength • 2x walks</p>
                    </div>
                    <span class="text-emerald-300 text-base">✓</span>
                </div>
                <div
                    class="flex items-center justify-between gap-2 rounded-xl border border-slate-700/70 bg-slate-900/80 px-3 py-2">
                    <div>
                        <p class="text-[0.75rem] font-semibold text-slate-50">Nutrition</p>
                        <p class="text-[0.7rem] text-slate-400">High-protein, flexible</p>
                    </div>
                    <span class="text-emerald-300 text-base">✓</span>
                </div>
                <div
                    class="flex items-center justify-between gap-2 rounded-xl border border-slate-700/70 bg-slate-900/80 px-3 py-2">
                    <div>
                        <p class="text-[0.75rem] font-semibold text-slate-50">Habits</p>
                        <p class="text-[0.7rem] text-slate-400">Sleep, steps, stress</p>
                    </div>
                    <span class="text-emerald-300 text-base">✓</span>
                </div>
                <div
                    class="flex items-center justify-between gap-2 rounded-xl border border-slate-700/70 bg-slate-900/80 px-3 py-2">
                    <div>
                        <p class="text-[0.75rem] font-semibold text-slate-50">Support</p>
                        <p class="text-[0.7rem] text-slate-400">Weekly check-ins + chat</p>
                    </div>
                    <span class="text-emerald-300 text-base">✓</span>
                </div>
            </div>

            <section id="about" class="border-t border-slate-800 pt-4 mt-2">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <div class="flex items-center gap-2">
                        <div
                            class="h-10 w-10 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-slate-950 font-bold text-xs">
                            JD
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-50">Coach Lee</p>
                            <p class="text-[0.7rem] text-slate-400">Strength & Lifestyle Coach</p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full border border-emerald-400/60 bg-emerald-500/10 px-2.5 py-1 text-[0.7rem] font-medium text-emerald-300">
                        Limited spots available
                    </span>
                </div>
                <p class="text-[0.76rem] text-slate-300">
                    I help busy professionals build strong, resilient bodies without sacrificing family, career, or the
                    foods they love. No crash diets, no 2-hour workouts—just simple, effective systems that fit your
                    life.
                </p>
            </section>
        </aside>
    </div>
</x-layout>
