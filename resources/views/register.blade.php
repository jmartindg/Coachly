<x-auth-layout>
    <x-slot:title>Register</x-slot:title>
    <h1 class="text-lg sm:text-xl font-semibold text-slate-50 mb-1">
        Create your account
    </h1>
    <p class="text-xs text-slate-400 mb-5">
        Sign up to get started with your coaching journey.
    </p>

    <form action="#" method="POST" class="space-y-4">
        @csrf

        <div class="space-y-1">
            <label for="name" class="block text-xs font-medium text-slate-200">
                Name
            </label>
            <input type="text" id="name" name="name"
                class="block w-full rounded-md border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="Your name" required>
        </div>

        <div class="space-y-1">
            <label for="email" class="block text-xs font-medium text-slate-200">
                Email
            </label>
            <input type="email" id="email" name="email"
                class="block w-full rounded-md border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="you@example.com" required>
        </div>

        <div class="space-y-1">
            <label for="password" class="block text-xs font-medium text-slate-200">
                Password
            </label>
            <input type="password" id="password" name="password"
                class="block w-full rounded-md border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="••••••••" required>
        </div>

        <button type="submit"
            class="mt-2 inline-flex w-full items-center justify-center rounded-full bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-slate-950 shadow-md shadow-emerald-500/40 hover:bg-emerald-400 transition-colors">
            Create account
        </button>
    </form>

    <p class="text-center text-[0.7rem] text-slate-400 mt-4">
        Already have an account?
        <a href="{{ route('login') }}" class="text-emerald-300 hover:text-emerald-200 transition-colors">Log in</a>
    </p>
</x-auth-layout>
