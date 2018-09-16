<?php

namespace App\Http\Controllers;


class MaterialController extends Controller
{
    
    public function image()
    {
        $app = app('wechat.official_account');
        $image = $app->material->uploadImage(public_path().'/images/qrcode_for_gh_c25035a188af_258.jpg');

        return $image;
    }
}
