<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ isset($title) ? $title . ' - Coach' : 'Coach - Coachly Fitness' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-50 flex flex-col">
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 flex-1 flex flex-col">
        <header class="mb-8 sm:mb-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex w-full items-center justify-between gap-4">
                <a href="{{ route('coach.index') }}" class="flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <div
                        class="h-9 w-9 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/40 flex items-center justify-center text-slate-950 font-extrabold text-xs">
                        C
                    </div>
                    <div>
                        <p class="text-sm font-semibold tracking-tight">Coachly Fitness</p>
                        <p class="text-xs text-slate-400">Online strength & lifestyle coaching</p>
                    </div>
                </a>

                <button type="button"
                    class="shrink-0 inline-flex lg:hidden items-center justify-center rounded-full border border-slate-700 px-2.5 py-1.5 text-xs font-medium text-slate-100 hover:border-slate-300 hover:text-slate-50 transition-colors"
                    aria-label="Toggle navigation" aria-expanded="false" aria-controls="primary-navigation"
                    data-mobile-menu-toggle>
                    <span class="flex flex-col justify-between h-3 w-3">
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                        <span class="block h-0.5 w-full rounded bg-slate-200"></span>
                    </span>
                </button>
            </div>

            <nav id="primary-navigation"
                class="hidden w-full flex-col rounded-xl border border-slate-800 bg-slate-950/95 px-4 py-4 text-sm text-slate-300 shadow-lg shadow-slate-950/60 lg:flex lg:w-auto lg:flex-row lg:items-center lg:justify-end lg:gap-4 lg:rounded-full lg:border-slate-800/70 lg:bg-slate-900/60 lg:px-4 lg:py-2 lg:text-xs lg:shadow-none"
                data-mobile-menu>
                <a href="{{ route('coach.index') }}"
                    class="whitespace-nowrap py-2 lg:py-0 lg:px-2 hover:text-slate-50 transition-colors">Dashboard</a>
                <a href="{{ route('coach.clients') }}"
                    class="whitespace-nowrap py-2 lg:py-0 lg:px-2 hover:text-slate-50 transition-colors">Clients</a>
                <a href="{{ route('coach.programs') }}"
                    class="whitespace-nowrap py-2 lg:py-0 lg:px-2 hover:text-slate-50 transition-colors">Programs</a>
                <a href="{{ route('coach.profile') }}"
                    class="whitespace-nowrap py-2 lg:py-0 lg:px-2 hover:text-slate-50 transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}"
                    class="mt-3 lg:mt-0 lg:ml-2">
                    @csrf
                    <button type="submit"
                        class="whitespace-nowrap block w-full text-left py-2 lg:inline lg:w-auto lg:py-0 lg:px-2 text-slate-400 hover:text-slate-50 transition-colors cursor-pointer">
                        Logout
                    </button>
                </form>
            </nav>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
