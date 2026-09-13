<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfirmModal extends Component
{
    public function __construct(
        public string $name,
        public string $title = 'Are you sure?',
        public string $message = 'This action cannot be undone.',
        public string $confirmText = 'Confirm',
        public string $confirmColor = 'danger', // danger, primary
        public string $icon = 'ri-error-warning-line',
    ) {}

    public function render()
    {
        return view('components.confirm-modal');
    }
}