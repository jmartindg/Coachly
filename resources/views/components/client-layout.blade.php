<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - Client' : 'Client - Coachly Fitness' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-50 flex flex-col">
    <div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1 flex flex-col">
        <header class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div
                    class="h-9 w-9 rounded-full bg-linear-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/40 flex items-center justify-center text-slate-950 font-extrabold text-xs">
                    C
                </div>
                <div>
                    <p class="text-sm font-semibold tracking-tight">Coachly Fitness</p>
                    <p class="text-xs text-slate-400">Online strength & lifestyle coaching</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <nav class="flex items-center gap-4">
                    <a href="{{ route('client.index') }}"
                        class="text-xs text-slate-400 hover:text-slate-50 transition-colors">Dashboard</a>
                    <a href="{{ route('client.profile') }}"
                        class="text-xs text-slate-400 hover:text-slate-50 transition-colors">Profile</a>
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center">
                    @csrf
                    <button type="submit"
                        class="text-xs text-slate-400 hover:text-slate-50 transition-colors cursor-pointer">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
