<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('properties', 'applications')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        abort_if($user->id === Auth::id(), 403, "You can't delete your own account.");

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}