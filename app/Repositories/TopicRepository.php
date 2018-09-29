<?php

namespace App\Repositories;

use App\Topic;
use Illuminate\Http\Request;


class TopicRepository
{
    public function getTopicsForTagging(Request $request)
    {
       return Topic::select(['id','name'])
            ->where('name','like','%'.$request->query('q').'%')
            ->get();
    }
}
