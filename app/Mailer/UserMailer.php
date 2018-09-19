<?php

namespace App\Mailer;


class UserMailer extends Mailer
{
    public function welcome($user)
    {
        dd("执行了~~~");
        $subject = 'hellohxr.cn 新用户邮箱确认';
        $view = 'welcome';
        $data = ['%name%' => [$user->name],'%token%' => [$user->confirm_code]];
        $this->sendTo($user, $subject, $view, $data);
    }
}
