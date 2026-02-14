<x-client-layout>
    <x-slot:title>Edit Profile</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Edit Profile</h1>
            <p class="text-sm text-slate-400">Your coach sees this information.</p>
        </section>

        <section class="rounded-2xl border border-slate-800 bg-slate-900/50 p-6 sm:p-8">
            <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                @if ($errors->isNotEmpty())
                    <p class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-300">
                        Please fix the errors below.
                    </p>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="name" class="block text-xs font-medium text-slate-400">Name</label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="block w-full rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                        @error('name')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-medium text-slate-400">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="block w-full rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                        @error('email')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="age" class="block text-xs font-medium text-slate-400">Age</label>
                        <input type="number" id="age" name="age"
                            value="{{ old('age', auth()->user()->age) }}" min="1" max="150"
                            class="block w-full rounded-md border {{ $errors->has('age') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                            placeholder="Optional">
                        @error('age')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="sex" class="block text-xs font-medium text-slate-400">Sex</label>
                        <div class="relative">
                            <select id="sex" name="sex"
                                class="block w-full appearance-none rounded-md border {{ $errors->has('sex') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 pl-3 pr-10 py-2 text-sm text-slate-50 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                <option value="">Select...</option>
                                @foreach (\App\Enums\Sex::cases() as $option)
                                    <option value="{{ $option->value }}" @selected(old('sex', auth()->user()->sex?->value) === $option->value)>
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
                    <div class="space-y-1">
                        <label for="height" class="block text-xs font-medium text-slate-400">Height (cm)</label>
                        <input type="number" id="height" name="height"
                            value="{{ old('height', auth()->user()->height) }}" min="100" max="250"
                            step="0.1"
                            class="block w-full rounded-md border {{ $errors->has('height') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                            placeholder="Optional">
                        @error('height')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="weight" class="block text-xs font-medium text-slate-400">Weight (kg)</label>
                        <input type="number" id="weight" name="weight"
                            value="{{ old('weight', auth()->user()->weight) }}" min="30" max="300"
                            step="0.1"
                            class="block w-full rounded-md border {{ $errors->has('weight') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                            placeholder="Optional">
                        @error('weight')
                            <p class="text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                        Save
                    </button>
                    <a href="{{ route('client.index') }}"
                        class="inline-flex items-center justify-center rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </section>
    </div>
</x-client-layout>
