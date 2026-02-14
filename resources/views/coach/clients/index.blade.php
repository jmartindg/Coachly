<x-coach-layout>
    <x-slot:title>Clients</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Clients</h1>
            <p class="text-sm text-slate-400">Manage applied clients and leads.</p>
        </section>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <div class="flex border-b border-slate-800" role="tablist">
                <a href="{{ route('coach.clients') }}?tab=applied"
                    class="flex-1 px-5 py-3 text-center text-sm font-medium transition-colors {{ $activeTab === 'applied' ? 'border-b-2 border-emerald-500 text-slate-50' : 'text-slate-400 hover:text-slate-50' }}">
                    Active ({{ $applied->count() }})
                </a>
                <a href="{{ route('coach.clients') }}?tab=pending"
                    class="flex-1 px-5 py-3 text-center text-sm font-medium transition-colors {{ $activeTab === 'pending' ? 'border-b-2 border-emerald-500 text-slate-50' : 'text-slate-400 hover:text-slate-50' }}">
                    Pending ({{ $pending->count() }})
                </a>
                <a href="{{ route('coach.clients') }}?tab=leads"
                    class="flex-1 px-5 py-3 text-center text-sm font-medium transition-colors {{ $activeTab === 'leads' ? 'border-b-2 border-emerald-500 text-slate-50' : 'text-slate-400 hover:text-slate-50' }}">
                    Leads ({{ $leads->count() }})
                </a>
                <a href="{{ route('coach.clients') }}?tab=finished"
                    class="flex-1 px-5 py-3 text-center text-sm font-medium transition-colors {{ $activeTab === 'finished' ? 'border-b-2 border-emerald-500 text-slate-50' : 'text-slate-400 hover:text-slate-50' }}">
                    Finished ({{ $finished->count() }})
                </a>
            </div>

            <div id="panel-applied" class="p-5 sm:p-6 space-y-4 {{ $activeTab === 'applied' ? '' : 'hidden' }}" role="tabpanel">
                <p class="text-xs text-slate-400">Approved clients who are actively coaching.</p>
                @if ($applied->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($applied as $client)
                            <li
                                class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-50">{{ $client->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $client->email }}</p>
                                    @if ($client->age || $client->sex || $client->height || $client->weight)
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ collect([
                                                $client->age ? $client->age . ' yrs' : null,
                                                $client->sex?->label(),
                                                $client->height ? $client->height . ' cm' : null,
                                                $client->weight ? $client->weight . ' kg' : null,
                                            ])->filter()->implode(' · ') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="shrink-0 flex items-center gap-3">
                                    <span
                                        class="rounded-md bg-slate-800/80 px-2.5 py-1 text-xs text-slate-400">{{ $client->created_at->format('M j, Y') }}</span>
                                    <a href="{{ route('coach.clients.show', $client) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        View
                                    </a>
                                    <form action="{{ route('coach.clients.revert', $client) }}" method="post"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-400 hover:border-slate-500 hover:text-slate-300 transition-colors">
                                            Move back to lead
                                        </button>
                                    </form>
                                    <form action="{{ route('coach.clients.finish', $client) }}" method="post"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-amber-500/50 px-3 py-1.5 text-xs font-medium text-amber-300 hover:border-amber-400 hover:text-amber-200 transition-colors">
                                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Mark finished
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                        <p class="text-sm text-slate-400">No applied clients yet. Promote leads when they onboard.</p>
                    </div>
                @endif
            </div>

            <div id="panel-pending" class="p-5 sm:p-6 space-y-4 {{ $activeTab === 'pending' ? '' : 'hidden' }}" role="tabpanel">
                <p class="text-xs text-slate-400">Applications awaiting your approval. Approve or move back to leads.</p>
                @if ($pending->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($pending as $applicant)
                            <li
                                class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-50">{{ $applicant->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $applicant->email }}</p>
                                    @if ($applicant->age || $applicant->sex || $applicant->height || $applicant->weight)
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ collect([
                                                $applicant->age ? $applicant->age . ' yrs' : null,
                                                $applicant->sex?->label(),
                                                $applicant->height ? $applicant->height . ' cm' : null,
                                                $applicant->weight ? $applicant->weight . ' kg' : null,
                                            ])->filter()->implode(' · ') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="shrink-0 flex items-center gap-3">
                                    <span
                                        class="rounded-md bg-slate-800/80 px-2.5 py-1 text-xs text-slate-400">{{ $applicant->created_at->format('M j, Y') }}</span>
                                    <a href="{{ route('coach.clients.show', $applicant) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        View
                                    </a>
                                    <form action="{{ route('coach.clients.promote', $applicant) }}" method="post"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('coach.clients.revert', $applicant) }}" method="post"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-400 hover:border-slate-500 hover:text-slate-300 transition-colors">
                                            Move back to lead
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                        <p class="text-sm text-slate-400">No pending applications.</p>
                    </div>
                @endif
            </div>

            <div id="panel-leads" class="p-5 sm:p-6 space-y-4 {{ $activeTab === 'leads' ? '' : 'hidden' }}" role="tabpanel">
                <p class="text-xs text-slate-400">Registered users who haven't applied yet. Or add manually with Mark active.
                </p>
                @if ($leads->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($leads as $lead)
                            <li
                                class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-50">{{ $lead->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $lead->email }}</p>
                                    @if ($lead->age || $lead->sex || $lead->height || $lead->weight)
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ collect([
                                                $lead->age ? $lead->age . ' yrs' : null,
                                                $lead->sex?->label(),
                                                $lead->height ? $lead->height . ' cm' : null,
                                                $lead->weight ? $lead->weight . ' kg' : null,
                                            ])->filter()->implode(' · ') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="shrink-0 flex items-center gap-3">
                                    <span
                                        class="rounded-md bg-slate-800/80 px-2.5 py-1 text-xs text-slate-400">{{ $lead->created_at->format('M j, Y') }}</span>
                                    <a href="{{ route('coach.clients.show', $lead) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        View
                                    </a>
                                    <form action="{{ route('coach.clients.promote', $lead) }}" method="post"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Mark active
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                        <p class="text-sm text-slate-400">No leads. New registrations will appear here.</p>
                    </div>
                @endif
            </div>

            <div id="panel-finished" class="p-5 sm:p-6 space-y-4 {{ $activeTab === 'finished' ? '' : 'hidden' }}" role="tabpanel">
                <p class="text-xs text-slate-400">Clients who have completed their program.</p>
                @if ($finished->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($finished as $client)
                            <li
                                class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-50">{{ $client->name }}</p>
                                    <p class="text-xs text-slate-400 truncate">{{ $client->email }}</p>
                                    @if ($client->age || $client->sex || $client->height || $client->weight)
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ collect([
                                                $client->age ? $client->age . ' yrs' : null,
                                                $client->sex?->label(),
                                                $client->height ? $client->height . ' cm' : null,
                                                $client->weight ? $client->weight . ' kg' : null,
                                            ])->filter()->implode(' · ') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="shrink-0 flex items-center gap-3">
                                    <span
                                        class="rounded-md bg-slate-800/80 px-2.5 py-1 text-xs text-slate-400">{{ $client->created_at->format('M j, Y') }}</span>
                                    <a href="{{ route('coach.clients.show', $client) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                        <p class="text-sm text-slate-400">No finished clients yet. Mark active clients as finished when they complete their program.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-coach-layout>
