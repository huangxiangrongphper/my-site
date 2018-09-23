<?php

namespace App\Repositories;

use App\Topic;
use App\Question;

/**
 * Class QuestionRepository
 *
 * @package \App\Repositries
 */
class QuestionRepository
{
    /**
     * @param $id
     *
     * @return \App\Question|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function byIdWithTopics($id)
    {
       return Question::with('topics')->where('id',$id)->first();
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function normalizeTopic(array $topics)
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
