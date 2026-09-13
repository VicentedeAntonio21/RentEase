<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    public function __construct(public Application $application) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $status = $this->application->status;

        return [
            'title' => 'Application '.$status,
            'message' => 'Your application for '.$this->application->unit->unit_name.' was '.$status.'.',
            'url' => route('applications.index'),
            'icon' => $status === 'approved' ? 'ri-checkbox-circle-line' : 'ri-close-circle-line',
            'color' => $status === 'approved' ? 'success' : 'danger',
        ];
    }
}