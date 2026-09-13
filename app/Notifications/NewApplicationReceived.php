<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
{
    public function __construct(public Application $application) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'New rental application',
            'message' => $this->application->tenant->name.' applied for '.$this->application->unit->unit_name,
            'url' => route('owner.applications.received'),
            'icon' => 'ri-inbox-archive-line',
            'color' => 'primary',
        ];
    }
}