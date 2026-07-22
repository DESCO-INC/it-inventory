<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function index()
    {
        // If user is logged in, redirect to items.index
        if (Auth::check()) {
            if (Auth::user()->credential === 'ADMIN') {
                return redirect()->route('units.index');
            } else {
                return redirect()->route('accountability.index');
            }
        }

        // Return login view for guests
        return response()->view('pages.auth.login')->header('Cache-Control', 'no-cache, no-store, must-revalidate')->header('Pragma', 'no-cache')->header('Expires', '0'); // prevent browser from caching login
    }

    public function login()
    {
        // validate
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // attempt login;
        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Email or Password is incorrect please try again.',
            ]);
        }

        //regenerate session
        request()->session()->regenerate();

        //redirect
        $redirect = Auth::user()->credential === 'ADMIN' ? '/units' : '/accountability';
        return redirect()->intended($redirect)->with('success', 'Login successful! Welcome 🎉');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
