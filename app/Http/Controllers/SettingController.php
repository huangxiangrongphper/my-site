<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function store(SettingRequest $request)
    {
       user()->settings()->merge($request->all());

        flash('个人信息修改成功💐💐','success')->important();
        return back();
    }
}
