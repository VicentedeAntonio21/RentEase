<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerificationReviewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VerificationController extends Controller
{
    public function index()
    {
        $pending = User::where('verification_status', 'pending')->latest()->get();

        return view('admin.verifications.index', compact('pending'));
    }

    public function document(User $user, string $type): StreamedResponse
    {
        abort_if(! in_array($type, ['id', 'ownership']), 404);

        $path = $type === 'id' ? $user->id_document_path : $user->ownership_document_path;

        abort_if(! $path || ! Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    public function approve(User $user)
    {
        $user->update([
            'verification_status' => 'verified',
            'verification_notes' => null,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        $user->notify(new VerificationReviewed('verified'));

        return back()->with('success', $user->name.' has been verified.');
    }

    public function reject(Request $request, User $user)
    {
        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $validated['notes'],
            'verified_at' => null,
            'verified_by' => Auth::id(),
        ]);

        $user->notify(new VerificationReviewed('rejected', $validated['notes']));

        return back()->with('success', $user->name.'\'s verification was rejected.');
    }
}