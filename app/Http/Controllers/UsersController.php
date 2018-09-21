<?php

namespace App\Http\Controllers;

use App\User;
use EasyWeChat\Payment\Kernel\Exceptions\SandboxException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;
use Mail;
use Naux\Mail\SendCloudTemplate;
use Auth;

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

         $email     = $request->get('email');
         $password  =  \Hash::make($request->get('password'));
         dd($password );
        $user = User::where(function($query) use($email,$password) {
            $query->where('email',$email)
                ->where('is_confirmed',1)
                ->where('password',$password);
        })->first();

        if(!$user){
            \Session::flash('user_login_failed','密码不正确或邮箱没验证');
            return back()->withInput();
        }

        return redirect('/');

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

            $user_email = User::where(function($query) use($email) {
                $query->where('email',$email)
                      ->where('is_confirmed',1);
             })->first();

            if(!$user_email){
                \Session::flash('password_reset_failed','没有找到对应邮箱信息或邮箱没激活');
                return redirect('/password/reset')->withInput();
            }

            \Session::flash('password_reset_success','验证信息已发送到您的邮箱,请马上重置您的密码');
            sleep(2);
            $token = $user_email->confirm_code;
            $this->sendPasswordResetNotification($token,$user_email);
        }
    }

    public function sendPasswordResetNotification($token,$user_email)
    {
        $data = [
            'url' => route('passwordReset',['token' => $token]),
        ];
        $template = new SendCloudTemplate('hellohxr',$data);

        Mail::raw($template,function ($message) use($user_email) {
            $message->from('huangxiangrong827@163.com','hellohxr.cn');
            $message->to($user_email->email);
        });
    }

    public function passwordReset(Request $request)
    {
        if($request->isMethod('get')){
            $confirm_code  = $request->input('token');
           Session::put('confirm_code',$confirm_code);
            return view('users.passwordReset');
        }else{
             $request->validate([
                'email'    => 'required|email|max:255',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ]);
            $email         = $request->get('email');
            $confirm_code  = Session::get('confirm_code','default');
            $user_info = User::where(function($query) use($email,$confirm_code) {
                $query->where('email',$email)
                    ->where('confirm_code',$confirm_code);
            })->first();

            if(!$user_info){
                \Session::flash('password_failed','没有找到对应的注册用户信息');
                return back()->withInput();
            }

            $user_info->email        = $request->get('email');
            $user_info->confirm_code = str_random(48);
            $user_info->save();
            \Session::flash('password_success','密码重置成功');
            sleep(2);
            Auth::loginUsingId($user_info->id);
            Session::put('confirm_code','default');
            dd($user_info->password);
            return redirect('/');
        }
    }
}
