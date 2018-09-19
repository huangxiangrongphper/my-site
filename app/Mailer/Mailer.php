<?php

namespace App\Mailer;

use Mail;
use Illuminate\Support\Facades\Log;
use Naux\Mail\SendCloudTemplate;

class Mailer
{

    public function sendTo($user)
    {
        $data = [
            'url'  => route('email.verify',['token' => $user->confirm_code]),
            'name' => $user->name
        ];
        $template = new SendCloudTemplate('welcome', $data);

        Mail::raw($template, function ($message) use ($user) {
            $message->from('huangxiangrong827@163.com', 'hellohxr.cn');

            $message->to($user->email);
        });

    }
}
