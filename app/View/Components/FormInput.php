<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public ?string $value = null,
        public bool $required = false,
        public ?string $placeholder = null,
        public ?string $icon = null,
        public ?string $step = null,
    ) {}

    public function render()
    {
        return view('components.form-input');
    }
}