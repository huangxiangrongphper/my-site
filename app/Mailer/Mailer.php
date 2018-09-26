<?php

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{

    protected function sendTo($template,$email,array $data)
    {

       $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from('huangxiangrong827@163.com', 'hellohxr.cn');
            $message->to($email);
        });

    }
}
