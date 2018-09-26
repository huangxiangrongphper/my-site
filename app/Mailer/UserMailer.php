<?php

namespace App\Mailer;
use App\User;
use Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
            'url'  => 'http://hellohxr.cn',
            'name' => Auth::guard('api')->user()->name
        ];

        $this->sendTo('user_follow_you',$email,$data);
    }

    public function passwordReset($email,$token)
    {
        $data = [
            'url' => route('passwordReset',['token' => $token]),
        ];

        $this->sendTo('hellohxr',$email,$data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url'  => route('email.verify',['token' => $user->confirm_code]),
            'name' => $user->name
        ];

        $this->sendTo('welcome',$user->email,$data);
    }
}
