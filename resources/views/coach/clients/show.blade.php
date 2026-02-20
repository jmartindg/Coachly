<x-coach-layout>
    <x-slot:title>{{ $client->name }} - Client Details</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('coach.clients') }}"
                class="text-xs text-slate-400 hover:text-slate-50 transition-colors flex items-center gap-1">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to clients
            </a>
        </div>

        <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6">
            <h1 class="text-xl font-semibold text-slate-50 mb-4">{{ $client->name }}</h1>
            <span
                class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ match ($client->client_status->value) {'applied' => 'bg-emerald-500/20 text-emerald-300','pending' => 'bg-amber-500/20 text-amber-300','finished' => 'bg-slate-500/20 text-slate-300',default => 'bg-slate-500/20 text-slate-400'} }}">
                {{ match ($client->client_status->value) {'applied' => 'Active','pending' => 'Pending approval','finished' => 'Finished',default => 'Lead'} }}
            </span>

            <dl class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-slate-400">Email</dt>
                    <dd class="text-sm text-slate-50">{{ $client->email }}</dd>
                </div>
                @if ($client->mobile_number)
                    <div>
                        <dt class="text-xs text-slate-400">Mobile Number</dt>
                        <dd class="text-sm text-slate-50">{{ $client->mobile_number }}</dd>
                    </div>
                @endif
                @if ($client->age)
                    <div>
                        <dt class="text-xs text-slate-400">Age</dt>
                        <dd class="text-sm text-slate-50">{{ $client->age }} yrs</dd>
                    </div>
                @endif
                @if ($client->sex)
                    <div>
                        <dt class="text-xs text-slate-400">Sex</dt>
                        <dd class="text-sm text-slate-50">{{ $client->sex->label() }}</dd>
                    </div>
                @endif
                @if ($client->height)
                    <div>
                        <dt class="text-xs text-slate-400">Height</dt>
                        <dd class="text-sm text-slate-50">{{ $client->height }} cm</dd>
                    </div>
                @endif
                @if ($client->weight)
                    <div>
                        <dt class="text-xs text-slate-400">Weight</dt>
                        <dd class="text-sm text-slate-50">{{ $client->weight }} kg</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs text-slate-400">Registered</dt>
                    <dd class="text-sm text-slate-50">{{ $client->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>

            @if ($client->formattedRequestedSession() && $client->client_status->value !== 'finished')
                <div class="mt-6 pt-6 border-t border-slate-800">
                    <h3 class="text-xs text-slate-400 uppercase tracking-[0.2em] mb-2">Requested session</h3>
                    <p class="text-sm text-slate-50">{{ $client->formattedRequestedSession() }}</p>
                </div>
            @endif

            @if (! empty($client->workout_style_preferences))
                <div class="mt-6 pt-6 border-t border-slate-800">
                    <h3 class="text-xs text-slate-400 uppercase tracking-[0.2em] mb-2">Preferred workout styles</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($client->workoutStylePreferenceLabels() as $styleLabel)
                            <span
                                class="inline-flex rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-300">
                                {{ $styleLabel }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($client->client_status->value === 'finished' && $programHistory->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-slate-800">
                    <h3 class="text-sm font-medium text-slate-300 mb-2">Program History</h3>
                    <ul class="space-y-2">
                        @foreach ($programHistory as $assignment)
                            <li
                                class="flex items-center justify-between gap-4 rounded-lg border border-slate-800 bg-slate-950/60 px-3 py-2">
                                <a href="{{ route('coach.programs.show', $assignment->program) }}"
                                    class="text-sm text-slate-200 hover:text-slate-50 transition-colors">{{ $assignment->program->name }}</a>
                                <span
                                    class="text-xs text-slate-500">{{ $assignment->assigned_at->format('M j, Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($client->client_status->value === 'applied' && $programs->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-slate-800">
                    <h3 class="text-sm font-medium text-slate-300 mb-2">Assign Program</h3>
                    @if ($currentProgram)
                        <p class="text-xs text-slate-400 mb-3">
                            Current:
                            <a href="{{ route('coach.programs.show', $currentProgram) }}"
                                class="text-slate-200 hover:text-slate-50 transition-colors">{{ $currentProgram->name }}</a>
                        </p>
                    @endif
                    <div class="space-y-2">
                        @foreach ($programs as $program)
                            @php($isCurrent = $currentProgram?->id === $program->id)
                            <div
                                class="flex items-center justify-between gap-4 rounded-lg border border-slate-800 bg-slate-950/60 px-3 py-2">
                                <a href="{{ route('coach.programs.show', $program) }}"
                                    class="text-sm text-slate-200 hover:text-slate-50 transition-colors">{{ $program->name }}</a>
                                <form action="{{ route('coach.clients.assign-program', $client) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-full px-3 py-1.5 text-xs font-medium {{ $isCurrent ? 'border border-slate-600 text-slate-400' : 'bg-emerald-500 text-slate-950 hover:bg-emerald-400' }} transition-colors cursor-pointer"
                                        {{ $isCurrent ? 'disabled' : '' }}>
                                        {{ $isCurrent ? 'Current' : 'Assign' }}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-6 flex gap-3">
                @if (in_array($client->client_status->value, ['lead', 'pending']))
                    <form action="{{ route('coach.clients.promote', $client) }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors cursor-pointer">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            {{ $client->client_status->value === 'pending' ? 'Approve' : 'Mark active' }}
                        </button>
                    </form>
                @endif
                @if (in_array($client->client_status->value, ['applied', 'pending']))
                    <form action="{{ route('coach.clients.revert', $client) }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-600 px-4 py-2 text-sm font-medium text-slate-400 hover:border-slate-500 hover:text-slate-300 transition-colors cursor-pointer">
                            Move back to lead
                        </button>
                    </form>
                @endif
                @if ($client->client_status->value === 'applied')
                    <form action="{{ route('coach.clients.finish', $client) }}" method="post">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-amber-500/50 px-4 py-2 text-sm font-medium text-amber-300 hover:border-amber-400 hover:text-amber-200 transition-colors cursor-pointer">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Mark finished
                        </button>
                    </form>
                @endif
            </div>
        </section>
    </div>
</x-coach-layout>
