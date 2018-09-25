<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    protected $user;


    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byId($id);

        $followers = $user->followersUser()->pluck('follower_id')->toArray();

        if(in_array(Auth::guard('api')->user()->id,$followers))
        {
            return response()->json(['followed' => true]);
        }

        return response()->json(['followed' => false]);
    }

    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));

        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);

        if(count($followed['attached']) > 0){
            //如果有用户关注 要通知问题用户 使用站内信

            $userToFollow->increment('followers_count');

            Auth::guard('api')->user()->increment('followings_count');
            return response()->json(['followed' => true]);
        }
        $userToFollow->decrement('followers_count');
        Auth::guard('api')->user()->decrement('followings_count');
        return response()->json(['followed' => false]);
    }
}
