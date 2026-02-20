<x-client-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="space-y-6">
        @if (session('success'))
            <p class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-300">
                {{ session('success') }}
            </p>
        @endif
        @if (session('info'))
            <p class="rounded-lg border border-slate-600 bg-slate-800/60 px-4 py-2 text-sm text-slate-300">
                {{ session('info') }}
            </p>
        @endif

        @php
            $user = auth()->user();
            $missing = collect([
                !$user->age ? 'age' : null,
                !$user->sex ? 'sex' : null,
                !$user->height ? 'height' : null,
                !$user->weight ? 'weight' : null,
            ])
                ->filter()
                ->values();
            $workoutStyleOptions = \App\Models\User::workoutStyleOptions();
            $defaultWorkoutStyles = $user->client_status->value === 'finished'
                ? []
                : ($user->workout_style_preferences ?? []);
            $selectedWorkoutStyles = collect(old('workout_style_preferences', $defaultWorkoutStyles))
                ->filter()
                ->values()
                ->all();
        @endphp
        @if ($missing->isNotEmpty())
            <div
                class="rounded-xl border border-amber-500/30 bg-amber-500/5 px-4 py-3 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-sm text-amber-200">
                    Complete your profile so your coach can personalize your program. Add {{ $missing->implode(', ') }}.
                </p>
                <a href="{{ route('client.profile') }}"
                    class="shrink-0 inline-flex items-center justify-center rounded-lg bg-amber-500/20 px-3 py-2 text-xs font-medium text-amber-200 hover:bg-amber-500/30 transition-colors">
                    Complete profile
                </a>
            </div>
        @endif

        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-50">Dashboard</h1>
            <p class="text-sm text-slate-400">Welcome back, {{ $user->name }}.</p>
        </section>

        @if ($user->client_status->value === 'lead')
            <section class="rounded-2xl border border-slate-800 bg-slate-900/50 p-6 sm:p-8">
                <h2 class="text-base font-semibold text-slate-50 mb-2">Ready to start?</h2>
                <p class="text-sm text-slate-400 mb-4">
                    Apply for coaching to become an active client. Your coach will receive your application and get in
                    touch.
                </p>
                @include('client.partials.apply-form', [
                    'buttonLabel' => 'Apply for coaching',
                    'workoutStyleOptions' => $workoutStyleOptions,
                    'selectedWorkoutStyles' => $selectedWorkoutStyles,
                ])
            </section>
        @endif

        @if ($user->client_status->value === 'pending')
            <section class="rounded-2xl border border-amber-500/30 bg-amber-500/5 p-6 sm:p-8">
                <h2 class="text-base font-semibold text-amber-300 mb-2">Awaiting coach approval</h2>
                <p class="text-sm text-slate-400">
                    Your application has been submitted. Your coach will review it and get in touch once you're
                    approved.
                </p>
                @if ($user->formattedRequestedSession())
                    <p class="mt-3 text-sm text-slate-300">
                        Your requested session: <span class="font-medium text-slate-50">{{ $user->formattedRequestedSession() }}</span>
                    </p>
                @endif
            </section>
        @endif

        @if ($user->client_status->value === 'applied')
            <section class="rounded-2xl border border-emerald-500/30 bg-emerald-500/5 p-6 sm:p-8">
                <h2 class="text-base font-semibold text-emerald-300 mb-2">You're an active client</h2>
                <p class="text-sm text-slate-400 mb-4">
                    Your coach has approved you and is ready to work with you. Keep your profile updated and check back
                    for your program.
                </p>
                @if ($user->formattedRequestedSession())
                    <p class="mb-4 text-sm text-slate-300">
                        Your requested session: <span class="font-medium text-slate-50">{{ $user->formattedRequestedSession() }}</span>
                    </p>
                @endif
                @if ($user->currentProgram())
                    <a href="{{ route('client.program') }}"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400 transition-colors">
                        View my program
                    </a>
                @else
                    <p class="text-xs text-slate-500">Your coach will assign your program soon.</p>
                @endif
            </section>
        @endif

        @if ($user->client_status->value === 'finished')
            <section class="rounded-2xl border border-slate-800 bg-slate-900/50 p-6 sm:p-8">
                <h2 class="text-base font-semibold text-slate-50 mb-2">Ready for another round?</h2>
                <p class="text-sm text-slate-400 mb-4">
                    You've completed your program. Apply again to start a new coaching cycle.
                </p>
                @include('client.partials.apply-form', [
                    'buttonLabel' => 'Apply again',
                    'workoutStyleOptions' => $workoutStyleOptions,
                    'selectedWorkoutStyles' => $selectedWorkoutStyles,
                ])
            </section>
        @endif

        <section class="rounded-2xl border border-slate-800 bg-slate-900/50 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-base font-semibold text-slate-50">Your profile</h2>
                <span
                    class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-medium {{ match ($user->client_status->value) {'applied' => 'bg-emerald-500/20 text-emerald-300','pending' => 'bg-amber-500/20 text-amber-300','finished' => 'bg-slate-500/20 text-slate-300',default => 'bg-slate-500/20 text-slate-400'} }}">
                    {{ match ($user->client_status->value) {'applied' => 'Active client','pending' => 'Awaiting approval','finished' => 'Program completed',default => 'On the list'} }}
                </span>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Name</dt>
                    <dd class="mt-0.5 text-sm text-slate-50">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Email</dt>
                    <dd class="mt-0.5 text-sm text-slate-50">{{ $user->email }}</dd>
                </div>
                @if ($user->mobile_number)
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Mobile Number</dt>
                        <dd class="mt-0.5 text-sm text-slate-50">{{ $user->mobile_number }}</dd>
                    </div>
                @endif
                @if ($user->age)
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Age</dt>
                        <dd class="mt-0.5 text-sm text-slate-50">{{ $user->age }} yrs</dd>
                    </div>
                @endif
                @if ($user->sex)
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Sex</dt>
                        <dd class="mt-0.5 text-sm text-slate-50">{{ $user->sex->label() }}</dd>
                    </div>
                @endif
                @if ($user->height)
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Height</dt>
                        <dd class="mt-0.5 text-sm text-slate-50">{{ $user->height }} cm</dd>
                    </div>
                @endif
                @if ($user->weight)
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Weight</dt>
                        <dd class="mt-0.5 text-sm text-slate-50">{{ $user->weight }} kg</dd>
                    </div>
                @endif
            </dl>

            <div class="mt-6 pt-6 border-t border-slate-800">
                <p class="text-xs text-slate-500 mb-3">
                    Your coach sees this profile. Keep it updated so they can personalize your program.
                </p>
                <a href="{{ route('client.profile') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-600 px-4 py-2 text-sm font-medium text-slate-300 hover:border-slate-500 hover:text-slate-50 transition-colors">
                    Edit profile
                </a>
            </div>
        </section>
    </div>
</x-client-layout>
