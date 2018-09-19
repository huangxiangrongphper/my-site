<?php

namespace App\Http\Controllers;

use App\Discussion;
use Illuminate\Http\Request;

class PostsController extends Controller
{


    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',['only'=>['create','store','edit','update']]);
    }

    public function index()
    {
        $discussions = Discussion::latest()->get();
        return view('forum.index',compact('discussions'));
    }

    public function show($id)
    {
        $discussion = Discussion::findOrFail($id);
        //$html = $this->markdown->markdown($discussion->body);
        return view('forum.show',compact('discussion'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $post = $request->validate([
            'title'    => 'required',
            'body' => 'required',
        ]);

        $data = [
            'user_id'       => \Auth::user()->id,
            'last_user_id'  => \Auth::user()->id,
        ];

        $post_data = array_merge($post,$data);

        $discussion = Discussion::create($post_data);

        return redirect()->action('PostsController@show',['id'=>$discussion->id]);

    }
}
