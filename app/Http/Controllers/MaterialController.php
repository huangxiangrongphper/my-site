<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public $material;

    /**
     * MaterialController constructor.
     *
     * @param $material
     */
    public function __construct(Application $material)
    {
        $this->material = $material->material;
    }

    public function image()
    {
        $image = $this->material
            ->uploadImage(public_path().'/images/qrcode_for_gh_c25035a188af_258.jpg');

        return $image;
    }
}
