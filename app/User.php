<?php

namespace App;

use App\Events\UserRegistered;
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
    protected $fillable = ['name', 'email', 'password','avatar','confirm_code','remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
