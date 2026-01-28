<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'investor')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'investor') {
            abort(404);
        }

        $user->load(['allocations.offering', 'transactions', 'documents']);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'investor') {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'investor') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,banned',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'next_of_kin_name' => 'nullable|string|max:255',
            'next_of_kin_email' => 'nullable|email|max:255',
            'next_of_kin_relationship' => 'nullable|string|max:100',
            'next_of_kin_phone' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'dob' => $request->dob,
            'address' => $request->address,
            'next_of_kin_name' => $request->next_of_kin_name,
            'next_of_kin_email' => $request->next_of_kin_email,
            'next_of_kin_relationship' => $request->next_of_kin_relationship,
            'next_of_kin_phone' => $request->next_of_kin_phone,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'investor') {
            abort(404); // Prevent deleting admins via this controller
        }

        // Optional: Check if user has active investments before deleting?
        // For now, standard delete.
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
