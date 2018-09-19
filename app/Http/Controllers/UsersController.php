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

        $data = [
            'confirm_code'=>str_random(48),
            'avatar'=>'/images/default-avatar.png'
        ];

        $userdata = array_merge($user,$data);

        User::register($userdata);

        return redirect('/');
    }

    public function confirmEmail($confirm_code)
    {
        $user = User::where('confirm_code',$confirm_code)->first();
        if(is_null($user)){
            return redirect('/');
        }

        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();

        return redirect('user/login');
    }
}
