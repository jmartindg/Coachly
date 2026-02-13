<x-client-layout>
    <x-slot:title>Profile</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6">
            <h1 class="text-lg font-semibold text-slate-50 mb-4">Your profile</h1>

            @if ($editing ?? false)
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
                            <label for="name" class="block text-xs text-slate-400">Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="block w-full rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                            @error('name')
                                <p class="text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="email" class="block text-xs text-slate-400">Email</label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="block w-full rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                            @error('email')
                                <p class="text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="age" class="block text-xs text-slate-400">Age</label>
                            <input type="number" id="age" name="age" value="{{ old('age', auth()->user()->age) }}"
                                min="1" max="150"
                                class="block w-full rounded-md border {{ $errors->has('age') ? 'border-red-500' : 'border-slate-700' }} bg-slate-950/60 px-3 py-2 text-sm text-slate-50 placeholder-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                                placeholder="Optional">
                            @error('age')
                                <p class="text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="sex" class="block text-xs text-slate-400">Sex</label>
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
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                            Save
                        </button>
                        <a href="{{ route('client.profile') }}"
                            class="inline-flex items-center justify-center rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            @else
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-slate-400">Name</dt>
                        <dd class="text-sm text-slate-50">{{ auth()->user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400">Email</dt>
                        <dd class="text-sm text-slate-50">{{ auth()->user()->email }}</dd>
                    </div>
                    @if (auth()->user()->email_verified_at)
                        <div>
                            <dt class="text-xs text-slate-400">Email verified</dt>
                            <dd class="text-sm text-slate-50">{{ auth()->user()->email_verified_at->format('M j, Y') }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-slate-400">Role</dt>
                        <dd class="text-sm text-slate-50">{{ auth()->user()->role->name }}</dd>
                    </div>
                    @if (auth()->user()->age)
                        <div>
                            <dt class="text-xs text-slate-400">Age</dt>
                            <dd class="text-sm text-slate-50">{{ auth()->user()->age }}</dd>
                        </div>
                    @endif
                    @if (auth()->user()->sex)
                        <div>
                            <dt class="text-xs text-slate-400">Sex</dt>
                            <dd class="text-sm text-slate-50">{{ auth()->user()->sex->name }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-slate-400">Member since</dt>
                        <dd class="text-sm text-slate-50">{{ auth()->user()->created_at->format('M j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400">Last updated</dt>
                        <dd class="text-sm text-slate-50">{{ auth()->user()->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </dl>

                <div class="pt-4">
                    <a href="{{ route('client.profile', ['edit' => 1]) }}"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                        Edit
                    </a>
                </div>
            @endif
        </section>
    </div>
</x-client-layout>
