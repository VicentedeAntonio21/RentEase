<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class VerificationReviewed extends Notification
{
    public function __construct(public string $status, public ?string $notes = null) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $approved = $this->status === 'verified';

        return [
            'title' => $approved ? 'Verification approved' : 'Verification rejected',
            'message' => $approved
                ? 'Your account is now verified. You can use all features.'
                : 'Your documents were rejected: '.$this->notes,
            'url' => route('profile.edit'),
            'icon' => $approved ? 'ri-shield-check-line' : 'ri-shield-cross-line',
            'color' => $approved ? 'success' : 'danger',
        ];
    }
}