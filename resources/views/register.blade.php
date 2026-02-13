<x-auth-layout>
    <x-slot:title>Register</x-slot:title>
    <h1 class="text-lg sm:text-xl font-semibold text-slate-50 mb-1">
        Create your account
    </h1>
    <p class="text-xs text-slate-400 mb-5">
        Sign up to get started with your coaching journey.
    </p>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        @if ($errors->isNotEmpty())
            <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                Please fix the errors below.
            </p>
        @endif

        <div class="space-y-1">
            <label for="name" class="block text-xs font-medium text-slate-200">
                Name
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                class="block w-full rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                placeholder="Your name" required>
            @error('name')
                <p class="text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

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

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1">
                <label for="age" class="block text-xs font-medium text-slate-200">
                    Age
                </label>
                <input type="number" id="age" name="age" value="{{ old('age') }}" min="1"
                    max="150"
                    class="block w-full rounded-md border {{ $errors->has('age') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                    placeholder="25">
                @error('age')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="sex" class="block text-xs font-medium text-slate-200">
                    Sex
                </label>
                <div class="relative">
                    <select id="sex" name="sex"
                        class="block w-full appearance-none rounded-md border {{ $errors->has('sex') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 pl-3 pr-10 py-2 text-sm text-slate-50 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                        <option value="">Select</option>
                        @foreach (\App\Enums\Sex::cases() as $option)
                            <option value="{{ $option->value }}" @selected(old('sex') === $option->value)>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                    </svg>
                </div>
                @error('sex')
                    <p class="text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
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

        <div class="space-y-1">
            <label for="password_confirmation" class="block text-xs font-medium text-slate-200">
                Confirm Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
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
