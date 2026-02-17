@props([
    'notifications' => collect(),
])

<div id="notification-panel" data-notification-panel
    class="hidden absolute right-0 top-12 z-50 w-80 max-w-[calc(100vw-2rem)] overflow-hidden rounded-xl border border-slate-800 bg-slate-900/95 shadow-xl shadow-slate-950/70 backdrop-blur">
    <div class="border-b border-slate-800 px-4 py-3">
        <h3 class="text-sm font-semibold text-slate-100">Notifications</h3>
    </div>

    <p data-notification-empty class="px-4 py-6 text-center text-xs text-slate-400 {{ $notifications->isEmpty() ? '' : 'hidden' }}">
        No notifications yet.
    </p>

    <ul data-notification-list class="max-h-96 divide-y divide-slate-800 overflow-y-auto {{ $notifications->isEmpty() ? 'hidden' : '' }}">
        @foreach ($notifications as $notification)
            @php($payload = is_array($notification->data) ? $notification->data : [])
            @php($notificationUrl = $payload['url'] ?? '#')
            @php($notificationTitle = $payload['title'] ?? 'Notification')
            @php($notificationMessage = $payload['message'] ?? 'You have a new update.')

            <li data-notification-item>
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

    <div class="border-t border-slate-800 px-4 py-3">
        <a href="{{ route('notifications.index') }}"
            class="block text-center text-xs font-medium text-emerald-300 transition-colors hover:text-emerald-200">
            View all notifications
        </a>
    </div>
</div>
