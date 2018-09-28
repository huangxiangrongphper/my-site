<?php

namespace App\Http\Controllers;

use App\Comment;
use Auth;
use App\Answer;
use App\Question;

class CommentsController extends Controller
{


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function answer($id)
    {
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();

        return $answer->comments;
    }

    public function question($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();

        return $question->comments;
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        $comment = Comment::create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ]);

        return $comment;
    }

    private function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
