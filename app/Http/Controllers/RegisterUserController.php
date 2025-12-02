<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class RegisterUserController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store()
    {
        //validate
        $attributes = request()->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'password' => ['required',Password::min(5), 'confirmed'] //password_confirmation
        ]);

        //create and save user
        $attributes['credential'] = 'USER';
        $user = User::create($attributes);

        //login
        Auth::login($user);

        //redirect with flash message
        if (Auth::user()->credential === 'ADMIN') {
            return redirect('/units')->with('success', 'Login successful! Welcome 🎉');
        } else {
            return redirect('/accountability')->with('success', 'Login successful! Welcome 🎉');
        }
    }
}
