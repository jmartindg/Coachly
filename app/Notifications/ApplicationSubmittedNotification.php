<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $client,
        public bool $isReapply,
    ) {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toArray(object $notifiable): array
    {
        $message = $this->isReapply
            ? "{$this->client->name} reapplied for coaching."
            : "{$this->client->name} applied for coaching.";

        return [
            'type' => 'application_submitted',
            'application_id' => $this->client->id,
            'title' => 'New coaching application',
            'message' => $message,
            'url' => route('coach.clients', ['tab' => 'pending']),
            'created_at' => now()->toISOString(),
        ];
    }
}
