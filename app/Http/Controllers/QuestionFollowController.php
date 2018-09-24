<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class QuestionFollowController extends Controller
{
    public function follow($question)
    {

        Auth::user()->followThis($question);

        return back();
    }
}
