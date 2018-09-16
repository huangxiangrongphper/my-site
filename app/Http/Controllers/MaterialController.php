<?php

namespace App\Http\Controllers;


use EasyWeChatComposer\EasyWeChat;

class MaterialController extends Controller
{

    public function image()
    {
        $officialAccount = EasyWeChat::officialAccount();
        $image = $officialAccount->material->uploadImage(public_path().'/images/qrcode_for_gh_c25035a188af_258.jpg');

        return $image;
    }
}
