<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - Coachly Fitness' : 'Coachly Fitness' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 flex flex-col">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 flex-1 flex flex-col">
        <header class="mb-8 sm:mb-10 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center justify-between gap-4 md:justify-start">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/40 flex items-center justify-center text-slate-950 font-extrabold text-xs">
                        C
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-tight">Coachly Fitness</p>
                        <p class="text-xs text-slate-400">Online strength & lifestyle coaching</p>
                    </div>
                </div>

                <button
                    type="button"
                    class="shrink-0 inline-flex items-center justify-center rounded-full border border-slate-700 px-2.5 py-1.5 text-xs font-medium text-slate-100 hover:border-slate-300 hover:text-slate-50 transition-colors md:hidden"
                    aria-label="Toggle navigation"
                    aria-expanded="false"
                    aria-controls="primary-navigation"
                    data-mobile-menu-toggle
                >
                    <span class="flex flex-col justify-between h-3 w-3">
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                    </span>
                </button>
            </div>

            <nav
                id="primary-navigation"
                class="w-full hidden flex-col rounded-xl border border-slate-800 bg-slate-950/95 px-4 py-4 text-sm text-slate-300 shadow-lg shadow-slate-950/60 md:w-auto md:flex md:flex-row md:items-center md:justify-end md:gap-4 md:rounded-full md:border-slate-800/70 md:bg-slate-900/60 md:px-4 md:py-2 md:text-xs md:shadow-none"
                data-mobile-menu
            >
                <a href="/" class="py-2 md:py-0 md:px-2 hover:text-slate-50 transition-colors">Home</a>
                <a href="/programs" class="py-2 md:py-0 md:px-2 hover:text-slate-50 transition-colors">Programs</a>
                <a href="/blog" class="py-2 md:py-0 md:px-2 hover:text-slate-50 transition-colors">Blog</a>
                <a href="/about" class="py-2 md:py-0 md:px-2 hover:text-slate-50 transition-colors">About</a>
                <a href="/contact" class="py-2 md:py-0 md:px-2 hover:text-slate-50 transition-colors">Contact</a>
                <a
                    href="/login"
                    class="mt-3 inline-flex items-center justify-center rounded-full border border-slate-600/70 px-3 py-1.5 text-xs font-medium text-slate-100 hover:border-slate-300 hover:text-slate-50 transition-colors md:mt-0 md:ml-2"
                >
                    Client Login
                </a>
            </nav>
        </header>

        <main class="flex-1 flex flex-col justify-center">
            {{ $slot }}
        </main>
    </div>

    <footer id="contact" class="border-t border-slate-800/80 bg-slate-950/80">
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-[0.7rem] sm:text-xs text-slate-500">
            <p>© {{ date('Y') }} Coachly Fitness. All rights reserved.</p>
            <div class="flex flex-wrap gap-4">
                <a href="mailto:hello@coachly.fit" class="hover:text-slate-300 transition-colors">hello@coachly.fit</a>
            </div>
        </div>
    </footer>
</body>
</html>
