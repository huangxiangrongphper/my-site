<?php

namespace App\Http\Controllers;

use App\Question;
use Auth;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{


    /**
     * QuestionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }


    public function index()
    {
        //
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
        $topics = $this->normalizeTopic($request->get('topics'));
        dd($topics);

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

       $question = Question::create($data);
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
        $question = Question::find($id);

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

    private function normalizeTopic(array $topics)
    {
       return collect($topics)->map(function ($topic){
           if(is_numeric($topic) && $topic_number = (int)$topic){
               if( $newTopic = Topic::find($topic_number) ){
                   $newTopic->increment('questions_count');
                   return $topic_number;
               }
           }

           if($newTopic = Topic::where('name',$topic)->first()){
               $newTopic->increment('questions_count');
               return $newTopic->id;
           }

           $newTopic = Topic::create(['name'=>$topic , 'questions_count'=>1]);
           return $newTopic->id;
       })->toArray();

    }
}
