<?php

namespace App\Notifications;

use App\Models\Program;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProgramAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $coach,
        public Program $program,
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
            'type' => 'program_assigned',
            'application_id' => $notifiable->id,
            'program_id' => $this->program->id,
            'title' => 'New program assigned',
            'message' => "{$this->coach->name} assigned you to {$this->program->name}.",
            'url' => route('client.program'),
            'created_at' => now()->toISOString(),
        ];
    }
}
