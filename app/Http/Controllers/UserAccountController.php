<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|confirmed',
            'password' => 'required|min:8|confirmed',
        ]));

        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('listings.index')
            ->with('success', 'Account created.');
    }
}
