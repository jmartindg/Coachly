<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - Coachly Fitness' : 'Coachly Fitness' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-50 flex flex-col">
    <div class="flex-1 flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-8">
        <div class="w-full max-w-md space-y-8">
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                <div
                    class="h-9 w-9 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/40 flex items-center justify-center text-slate-950 font-extrabold text-xs">
                    C
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-sm font-semibold tracking-tight">Coachly Fitness</p>
                    <p class="text-xs text-slate-400">Online strength & lifestyle coaching</p>
                </div>
            </a>

            <div
                class="rounded-2xl border border-slate-800 bg-slate-900/70 px-5 py-6 sm:px-6 sm:py-7 shadow-2xl shadow-slate-950/60">
                {{ $slot }}
            </div>

            <p class="text-[0.7rem] text-center text-slate-500">
                Not a client yet?
                <a href="/" class="text-emerald-300 hover:text-emerald-200 transition-colors">Learn more about
                    coaching</a>
            </p>
        </div>
    </div>
</body>

</html>
