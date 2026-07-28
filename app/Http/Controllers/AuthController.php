<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\AuditTrail;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
                return redirect()->route('inventory.index');
        }

        return response()->view('auth.login')->header('Cache-Control', 'no-cache, no-store, must-revalidate')->header('Pragma', 'no-cache')->header('Expires', '0');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Email or Password is incorrect please try again.',
            ]);
        }

        request()->session()->regenerate();

        AuditTrail::create([
            'user_id' => Auth::id(),
            'action' => 'login',
            'model' => 'User',
            'model_id' => Auth::id(),
            'old_values' => null,
            'new_values' => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'logged_in_at' => now(),
            ],
        ]);

        $redirect = Auth::user()->credential === 'ADMIN' ? '/inventory' : '/accountability';
        return redirect()->intended($redirect)->with('success', 'Login successful! Welcome 🎉');
    }

    public function destroy()
    {
        AuditTrail::create([
            'user_id' => Auth::id(),
            'action' => 'logout',
            'model' => 'User',
            'model_id' => Auth::id(),
            'old_values' => null,
            'new_values' => [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'logged_out_at' => now(),
            ],
        ]);

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('info', 'Logout successfully!');
    }
}
