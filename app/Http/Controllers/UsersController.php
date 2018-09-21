<?php

namespace App\Http\Controllers;

use App\User;
use EasyWeChat\Payment\Kernel\Exceptions\SandboxException;
use Illuminate\Http\Request;
use Image;

class UsersController extends Controller
{
    public function register()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'name'     => 'required|min:3|max:255' ,
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $data = [
            'confirm_code'=>str_random(48),
            'avatar'=>'/images/default-avatar.png'
        ];

        $userdata = array_merge($user,$data);

        User::register($userdata);

        return redirect('/');
    }

    public function confirmEmail($confirm_code)
    {
        $user = User::where('confirm_code',$confirm_code)->first();
        if(is_null($user)){
            return redirect('/');
        }

        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();

        return redirect('user/login');
    }

    public function login()
    {
        return view('users.login');
    }

    public function signin(Request $request)
    {
         $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(\Auth::attempt([
            'email'        => $request->get('email'),
            'password'     => $request->get('password'),
            'is_confirmed' => 1
        ])){
            return redirect('/');
        }
        \Session::flash('user_login_failed','密码不正确或邮箱没验证');
        return redirect('/user/login')->withInput();
    }

    public function avatar()
    {
        return view('users.avatar');
    }

    public function changeAvatar(Request $request)
    {
        $file = $request->file('avatar');
        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );
        $validator = \Validator::make($input, $rules);
        if ( $validator->fails() ){
            return \Response::json([
                'success' => false,
                'errors'  => $validator->getMessageBag()->toArray(),
            ]);
        }

        $destinationPath = 'uploads/';
        $filename = \Auth::user()->id.'_'.time().$file->getClientOriginalName();
        $file->move($destinationPath,$filename);
        Image::make($destinationPath.$filename)->fit(400)->save();


        return \Response::json([
            'success' => true,
            'avatar'  => asset($destinationPath.$filename),
            'image'  => $destinationPath.$filename,
        ]);

    }

    public function cropAvatar(Request $request)
    {
        $photo = $request->get('photo');
        $width = (int) $request->get('w');
        $height= (int) $request->get('h');
        $xAlign = (int) $request->get('x');
        $yAlign = (int) $request->get('y');

        Image::make($photo)->crop($width,$height,$xAlign,$yAlign)->save();

        $user = \Auth::user();
        $user->avatar = asset($photo);
        $user->save();

        return redirect('/user/avatar');
    }


    public function logout()
    {
        \Auth::logout();
        return redirect('/');
    }

    public function reset(Request $request)
    {
        if($request->isMethod('get')){
            return view('users.reset');
        }else{
            $request->validate([
                'email'    => 'required|email',
            ]);

            $email = $request->get('email');

            $user_email = User::findOrFail($email);

            if(!$user_email){
                dd($request->get('email'));
                \Session::flash('password_reset_failed','没有找到对应邮箱信息');
                return redirect('/password/reset')->withInput();
            }
        }
    }
}
