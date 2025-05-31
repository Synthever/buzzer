<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('role', 'user')->with(['tasks', 'collaborators', 'collaboratorOf'])->get();
        return response()->json($users);
    }

    public function showUser(User $user)
    {
        $user->load(['tasks', 'collaborators', 'collaboratorOf']);
        return response()->json($user);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|unique:users,username,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email', 'username']));

        return response()->json(['success' => 'User updated successfully']);
    }

    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('BuzzIn@123')
        ]);

        return response()->json(['success' => 'Password reset to BuzzIn@123']);
    }

    public function createCollaboration(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'collaborator_id' => 'required|exists:users,id|different:user_id'
        ]);

        // Create two-way collaboration
        Collaboration::firstOrCreate([
            'user_id' => $request->user_id,
            'collaborator_id' => $request->collaborator_id
        ]);

        Collaboration::firstOrCreate([
            'user_id' => $request->collaborator_id,
            'collaborator_id' => $request->user_id
        ]);

        return response()->json(['success' => 'Collaboration created successfully']);
    }

    public function destroyCollaboration(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'collaborator_id' => 'required|exists:users,id'
        ]);

        // Remove both directions
        Collaboration::where([
            'user_id' => $request->user_id,
            'collaborator_id' => $request->collaborator_id
        ])->delete();

        Collaboration::where([
            'user_id' => $request->collaborator_id,
            'collaborator_id' => $request->user_id
        ])->delete();

        return response()->json(['success' => 'Collaboration removed successfully']);
    }
}
