<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class NewVerificationSubmitted extends Notification
{
    public function __construct(public User $user) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'New verification request',
            'message' => $this->user->name.' ('.ucfirst($this->user->role).') submitted documents for review',
            'url' => route('admin.verifications.index'),
            'icon' => 'ri-shield-user-line',
            'color' => 'primary',
        ];
    }
}