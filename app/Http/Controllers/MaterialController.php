<?php

namespace App\Http\Controllers;


use EasyWeChat\Factory;

class MaterialController extends Controller
{

    public function image()
    {
        $officialAccount = Factory::officialAccount();
        $image = $officialAccount->material->uploadImage(public_path().'/images/qrcode_for_gh_c25035a188af_258.jpg');

        return $image;
    }
}
