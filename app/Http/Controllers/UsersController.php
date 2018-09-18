<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'name'     => 'required|min:3' ,
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        User::create(array_merge($user,['avatar'=>'/images/default-avatar.png']));

        return redirect('/');
    }
}
