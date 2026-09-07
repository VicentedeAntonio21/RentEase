<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Tenant: show their own applications.
     */
    public function index()
    {
        $applications = Auth::user()->applications()
            ->with('unit.property')
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    /**
     * Tenant: show the form to apply for a specific unit.
     */
    public function create(Unit $unit)
    {
        abort_if(! Auth::user()->isTenant(), 403, 'Only tenants can apply.');
        abort_if($unit->status !== 'available', 403, 'This unit is not available.');

        return view('applications.create', compact('unit'));
    }

    /**
     * Tenant: submit the application.
     */
    public function store(Request $request, Unit $unit)
    {
        abort_if(! Auth::user()->isTenant(), 403, 'Only tenants can apply.');
        abort_if($unit->status !== 'available', 403, 'This unit is not available.');

        $validated = $request->validate([
            'move_in_date' => ['required', 'date', 'after_or_equal:today'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->applications()->create([
            'unit_id' => $unit->id,
            'status' => 'pending',
            ...$validated,
        ]);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Application submitted! The owner will review it soon.');
    }

    /**
     * Tenant: cancel their own pending application.
     */
    public function cancel(Application $application)
    {
        $this->authorize('cancel', $application);

        $application->update(['status' => 'cancelled']);

        return back()->with('success', 'Application cancelled.');
    }

    /**
     * Owner: list applications for all their properties' units.
     */
    public function received()
    {
        $applications = Application::whereHas('unit.property', function ($q) {
            $q->where('owner_id', Auth::id());
        })
            ->with('unit.property', 'tenant')
            ->latest()
            ->get();

        return view('applications.received', compact('applications'));
    }

    /**
     * Owner: approve an application (and mark the unit occupied).
     */
    public function approve(Application $application)
    {
        $this->authorize('manage', $application);

        $application->update(['status' => 'approved']);
        $application->unit->update(['status' => 'occupied']);

        // Auto-reject other pending applications for the same unit
        Application::where('unit_id', $application->unit_id)
            ->where('id', '!=', $application->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Application approved. Unit marked as occupied.');
    }

    /**
     * Owner: reject an application.
     */
    public function reject(Application $application)
    {
        $this->authorize('manage', $application);

        $application->update(['status' => 'rejected']);

        return back()->with('success', 'Application rejected.');
    }
}