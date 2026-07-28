<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // For password hashing
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Only allow ADMIN users
        if (!Auth::check() || Auth::user()->credential !== 'ADMIN') {
            return redirect()->route('accountability.index')->with('error', 'Access denied: Admins only!');
        }

        $query = User::query();

        $search = $request->input('search', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('maintenance.users', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'credential' => 'nullable|string|max:255',
            'password' => 'required|string|min:5|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'credential' => $validated['credential'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'User added successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'credential' => 'required|string|in:ADMIN,USER',
            'password' => 'nullable|string|min:5|confirmed',
        ]);
        $data = $validated;
        $data['name'] = strtoupper($data['name']);

        // Handle password separately
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return back()->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    public function profile()
    {
        return view('maintenance.profile');
    }
}
