<?php

namespace App\Http\Controllers;

use App\Mailer\UserMailer;
use App\Notifications\UserRegisterNotification;
use App\User;
use EasyWeChat\Payment\Kernel\Exceptions\SandboxException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
            'avatar'=>'/images/default-avatar.png',
            'password' => bcrypt($request->get('password')),
            'api_token' => str_random(60),
            'settings' => ['city' => ''],
        ];

        $userdata = array_merge($user,$data);

        $user = User::register($userdata);

        $user->notify(new UserRegisterNotification($user));

        sleep(2);
        \Session::flash('user_register_success','恭喜您,注册成功.请马上去邮箱激活账号🤗');

        return back()->withInput();
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
            flash('欢迎回来!😘😘  '.Auth::user()->name,'success')->important();
            return redirect('/about');
        }
        sleep(2);
        \Session::flash('user_login_failed','密码不正确或邮箱没验证🙃');
        return redirect('/user/login')->withInput();
    }

    public function avatar()
    {
        return view('users.avatar');
    }

    public function changeAvatar(Request $request)
    {
        $file      = $request->file('img');
        $filename  = 'avatars/'.md5(time().user()->id).'.'.$file->getClientOriginalExtension();
        Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));

        user()->avatar = 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;
        user()->save();

        return ['url' => user()->avatar];
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
                sleep(2);
                \Session::flash('password_reset_failed','没有找到对应邮箱信息或邮箱没激活🙃');
                return redirect('/password/reset')->withInput();
            }

            $token = $user_email->confirm_code;
            $this->sendPasswordResetNotification($token,$user_email);

            return back();
        }
    }

    public function sendPasswordResetNotification($token,$user_email)
    {
        (new UserMailer())->passwordReset($user_email->email,$token);

        \Session::flash('password_reset_success','验证信息已发送到您的邮箱,请马上重置您的密码🤗');
        return back()->withInput();
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
                sleep(2);
                \Session::flash('password_failed','没有找到对应的注册用户信息🙃');
                return back()->withInput();
            }

            $user_info->email        = $request->get('email');
            $user_info->confirm_code = str_random(48);
            $user_info->password = bcrypt($request->get('password'));
            $user_info->save();

            Auth::loginUsingId($user_info->id);
            Session::put('confirm_code','default');
            return redirect('/');
        }
    }

    public function about()
    {
        return view('users.about');
    }
}
