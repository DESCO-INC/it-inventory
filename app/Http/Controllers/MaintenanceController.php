<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // For password hashing
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    // Show users with search and pagination
    public function users(Request $request)
    {
        $query = User::query();
        $search = $request->input('search', '');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('maintenance.users', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'credential' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed', // expects password_confirmation
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'credential' => $validated['credential'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'User added successfully!');
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'credential' => 'required|string|in:ADMIN,USER',
            'password' => 'nullable|string|min:6|confirmed', // optional
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->credential = $validated['credential'];

        // Only update password if a value is entered
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    // Reports
    public function reports()
    {
        $count = Inventory::count();
        return view('maintenance.reports', compact('count'));
    }
}
