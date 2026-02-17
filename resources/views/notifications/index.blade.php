<x-dynamic-component :component="$layoutComponent">
    <x-slot:title>Notifications</x-slot:title>

    <section class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:p-6">
        <div class="mb-4 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-50">All notifications</h1>
                <p class="text-xs text-slate-400">Latest updates from your coaching activity.</p>
            </div>
            <a href="{{ auth()->user()->isCoach() ? route('coach.index') : route('client.index') }}"
                class="inline-flex items-center justify-center rounded-full border border-slate-700 px-3 py-1.5 text-xs text-slate-300 transition-colors hover:border-slate-500 hover:text-slate-100">
                Back to dashboard
            </a>
        </div>

        @if ($notifications->isEmpty())
            <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-center">
                <p class="text-sm text-slate-400">No notifications yet.</p>
            </div>
        @else
            <ul class="overflow-hidden rounded-xl border border-slate-800 bg-slate-950/60">
                @foreach ($notifications as $notification)
                    @php($payload = is_array($notification->data) ? $notification->data : [])
                    @php($notificationUrl = $payload['url'] ?? '#')
                    @php($notificationTitle = $payload['title'] ?? 'Notification')
                    @php($notificationMessage = $payload['message'] ?? 'You have a new update.')

                    <li data-notification-item class="border-b border-slate-800 last:border-b-0">
                        <a data-notification-link data-notification-id="{{ $notification->id }}" href="{{ $notificationUrl }}"
                            class="flex items-start gap-3 px-4 py-3 transition-colors hover:bg-slate-800/60 {{ is_null($notification->read_at) ? 'bg-slate-800/30' : '' }}">
                            <span data-notification-item-unread
                                class="mt-1.5 inline-block h-2 w-2 shrink-0 rounded-full bg-emerald-400 {{ is_null($notification->read_at) ? '' : 'hidden' }}"></span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-xs font-semibold text-slate-100">{{ $notificationTitle }}</span>
                                <span class="mt-0.5 block text-xs text-slate-400">{{ $notificationMessage }}</span>
                                <span class="mt-1 block text-[0.65rem] text-slate-500">{{ $notification->created_at?->diffForHumans() }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </section>
</x-dynamic-component>
