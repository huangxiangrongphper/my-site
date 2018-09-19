@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error  }}</li>
                        @endforeach
                    </ul>
                @endif
                @if(Session::has('user_login_failed'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('user_login_failed') }}
                    </div>
                @endif
                <form action="/user/register" method="POST" accept-charset="UTF-8">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="control-label">邮箱:</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="请填写正确的邮箱地址">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">密码:</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="请输入您的密码">
                    </div>
                    <button type="submit" class="btn btn-success form-control">马上登录</button>
                </form>
            </div>
        </div>
    </div>
@stop
