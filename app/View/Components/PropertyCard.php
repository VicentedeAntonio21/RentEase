<?php

namespace App\View\Components;

use App\Models\Unit;
use Illuminate\View\Component;

class PropertyCard extends Component
{
    public function __construct(
        public Unit $unit,
    ) {}

    public function render()
    {
        return view('components.property-card');
    }
}