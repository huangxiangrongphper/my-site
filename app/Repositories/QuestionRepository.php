<?php

namespace App\Repositories;

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
}
