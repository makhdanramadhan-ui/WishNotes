<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:72',
        ]);
        auth()->login(\App\Models\User::create($fields));
        $request->session()->regenerate();

        return to_route('dashboard');
    }
}
