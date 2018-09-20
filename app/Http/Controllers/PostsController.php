<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Markdown\Markdown;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $markdown;

    public function __construct(Markdown $markdown)
    {
        $this->middleware('auth',['only'=>['create','store','edit','update']]);
        $this->markdown = $markdown;
    }

    public function index()
    {
        $discussions = Discussion::latest()->get();
        return view('forum.index',compact('discussions'));
    }

    public function show($id)
    {
        $discussion = Discussion::findOrFail($id);
        $html = $this->markdown->markdown($discussion->body);
        return view('forum.show',compact('discussion','html'));
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

    public function edit($id)
    {
        $discussion = Discussion::findOrFail($id);

        return view('forum.edit',compact('discussion'));
    }

    public function update(Request $request,$id)
    {
        dd($id);
    }
}
