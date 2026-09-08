<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with('unit.property.owner', 'tenant')
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }
}