<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatCard extends Component
{
    public function __construct(
        public string $label,
        public string $value,
        public string $icon,
        public string $color = 'primary', // primary, success, warning, danger
    ) {}

    public function render()
    {
        return view('components.stat-card');
    }
}