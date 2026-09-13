<?php

namespace App\Http\Controllers;

use App\Notifications\NewVerificationSubmitted;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function edit()
    {
        return view('verification.edit');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'id_document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ];

        if ($user->isOwner()) {
            $rules['ownership_document'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'];
        }

        $validated = $request->validate($rules);

        if ($user->id_document_path) {
            Storage::disk('local')->delete($user->id_document_path);
        }
        if ($user->ownership_document_path) {
            Storage::disk('local')->delete($user->ownership_document_path);
        }

        $idPath = $request->file('id_document')->store('verification/'.$user->id, 'local');

        $ownershipPath = null;
        if ($user->isOwner()) {
            $ownershipPath = $request->file('ownership_document')->store('verification/'.$user->id, 'local');
        }

        $user->update([
            'id_document_path' => $idPath,
            'ownership_document_path' => $ownershipPath,
            'verification_status' => 'pending',
            'verification_notes' => null,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewVerificationSubmitted($user));
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Documents submitted! An admin will review them within 24 hours.');
    }
}