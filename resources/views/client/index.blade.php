<x-client-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6">
            <h1 class="text-lg font-semibold text-slate-50 mb-4">Your account</h1>
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs text-slate-400">Name</dt>
                    <dd class="text-sm text-slate-50">{{ auth()->user()->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-400">Email</dt>
                    <dd class="text-sm text-slate-50">{{ auth()->user()->email }}</dd>
                </div>
            </dl>
        </section>
    </div>
</x-client-layout>
