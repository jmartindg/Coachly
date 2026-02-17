<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CoachingFinishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $coach,
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
        return [
            'type' => 'coaching_finished',
            'application_id' => $notifiable->id,
            'title' => 'Coaching cycle finished',
            'message' => "{$this->coach->name} marked your coaching cycle as finished.",
            'url' => route('client.index'),
            'created_at' => now()->toISOString(),
        ];
    }
}
