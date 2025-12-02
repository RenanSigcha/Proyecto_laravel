<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('livewire.pages.admin.usuarios', compact('users'));
    }

    public function updateRole(User $user)
    {
        request()->validate([
            'role' => 'required|in:admin,cliente',
        ]);

        $user->role = request('role');
        $user->save();

        return back()->with('status', 'Role actualizado correctamente.');
    }
}
