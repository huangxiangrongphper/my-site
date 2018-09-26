<?php

namespace App;

use App\Events\UserRegistered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','avatar','confirm_code','remember_token','api_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    public function follows()
    {
      return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    public function followed($question)
    {
        return !! $this->follows()->where('question_id',$question)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

    public function followersUser()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVotedFor($answer)
    {
        return !! $this->votes()->where('answer_id',$answer)->count();
    }
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

/*    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }*/

    public static function register(array $attributes)
    {
        $user = static::create($attributes);

        event(new UserRegistered($user));

        return $user;
    }
}
