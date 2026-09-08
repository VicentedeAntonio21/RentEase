<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarLink extends Component
{
    public function __construct(
        public string $href,
        public string $icon,
        public bool $active = false,
    ) {}

    public function render()
    {
        return view('components.sidebar-link');
    }
}