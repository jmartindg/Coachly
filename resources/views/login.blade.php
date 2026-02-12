<x-auth-layout>
    <x-slot:title>Login</x-slot:title>
    <h1 class="text-lg sm:text-xl font-semibold text-slate-50 mb-1">
        Welcome back
    </h1>
    <p class="text-xs text-slate-400 mb-5">
        Log in to view your programs, check-ins, and progress.
    </p>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        @if ($errors->isNotEmpty())
            <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                Please fix the errors below.
            </p>
        @endif

        <div class="space-y-1">
            <label for="email" class="block text-xs font-medium text-slate-200">
                Email
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="block w-full rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="you@example.com" required>
            @error('email')
                <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1">
            <label for="password" class="block text-xs font-medium text-slate-200">
                Password
            </label>
            <input type="password" id="password" name="password"
                class="block w-full rounded-md border {{ $errors->has('password') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="••••••••" required>
            @error('password')
                <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between gap-3">
            <label class="inline-flex items-center gap-2 text-[0.7rem] text-slate-300">
                <input type="checkbox" name="remember"
                    class="h-3.5 w-3.5 rounded border-slate-600 bg-slate-950/80 text-emerald-500 focus:ring-emerald-500">
                <span>Remember me</span>
            </label>

            <a href="#" class="text-[0.7rem] text-emerald-300 hover:text-emerald-200 transition-colors">
                Forgot password?
            </a>
        </div>

        <button type="submit"
            class="mt-2 inline-flex w-full items-center justify-center rounded-full bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-slate-950 shadow-md shadow-emerald-500/40 hover:bg-emerald-400 transition-colors">
            Log in
        </button>
    </form>

    <p class="text-center text-[0.7rem] text-slate-400 mt-4">
        Don't have an account yet?
        <a href="{{ route('register') }}" class="text-emerald-300 hover:text-emerald-200 transition-colors">Sign up</a>
    </p>
</x-auth-layout>
