<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.'])->onlyInput('email');
    }
}
