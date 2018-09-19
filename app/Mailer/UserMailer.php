<?php

namespace App\Mailer;


class UserMailer extends Mailer
{
    public function welcome($user)
    {
        $this->sendTo($user);
    }
}
