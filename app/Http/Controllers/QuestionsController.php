<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Auth;
use Illuminate\Http\Request;

/**
 * Class QuestionsController
 *
 * @package App\Http\Controllers
 */
class QuestionsController extends Controller
{

    /**
     * @var \App\Repositories\QuestionRepository
     */
    protected $questionRepository;

    /**
     * QuestionsController constructor.
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }


    /**
     *
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('topics')){

          $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        }

        $rules = [
            'title' => 'required|min:6|max:196',
            'body'  => 'required|min:26',
        ];

        $message = [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于6个字符',
            'title.max' => '标题最大长度不能超过196个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能少于26个字符',
        ];

        $this->validate($request,$rules,$message);

        $data = [
            'title'   => $request->get('title'),
            'body'   => $request->get('body'),
            'user_id' => Auth::id()
        ];

       $question = $this->questionRepository->create($data);

       if($topics){
           $question->topics()->attach($topics);
       }

       return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopics($id);

        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)){
           return view('questions.edit',compact('question'));
        }

        return back();
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
        $rules = [
            'title' => 'required|min:6|max:196',
            'body'  => 'required|min:26',
            ''
        ];

        $message = [
            'title.required' => '标题不能为空',
            'title.min' => '标题不能少于6个字符',
            'title.max' => '标题最大长度不能超过196个字符',
            'body.required' => '内容不能为空',
            'body.min' => '内容不能少于26个字符',
        ];

        $this->validate($request,$rules,$message);

        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);

        return redirect()->route('question.show',[$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)) {
            $question->delete();
            return redirect('/');
        }

        abort(403,'Forbidden');// return back();
    }
}
