<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Auth;

class CommentsController extends Controller
{
    protected $questionRepository;
    protected $AnswerRepository;
    protected $commentRepository;

    /**
     * CommentsController constructor.
     *
     * @param $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository,AnswerRepository $AnswerRepository,CommentRepository $commentRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->AnswerRepository   = $AnswerRepository;
        $this->commentRepository = $commentRepository;
    }

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
        return $this->AnswerRepository->getAnswerCommentsById($id);
    }

    public function question($id)
    {
        return $this->questionRepository->getQuestionCommentsById($id);
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        if($model === 'App\Question')
        {
            $question  = $this->questionRepository->byId(request('model'));
            $question->increment('comments_count');
            $question->save();
        }else{
            $answer = $this->AnswerRepository->byId(request('model'));
            $answer->increment('comments_count');
            $answer->save();
        }

        return $this->commentRepository->create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ]);
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
