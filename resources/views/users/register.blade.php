@extends('registerApp')
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
                @if(Session::has('user_register_success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('user_register_success') }}
                    </div>
                @endif
                <form action="/user/register" method="POST" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="control-label">用户名:</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="请输入您的用户名">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">邮箱:</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="请填写正确的邮箱地址">
                    </div>
                    <div class="form-group">
                      <label for="password" class="control-label">密码:</label>
                      <input id="password" name="password" type="password" class="form-control" placeholder="请输入您的密码">
                    </div>
                    <div class="form-group">
                      <label for="password_confirmation" class="control-label">确认密码:</label>
                      <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="请确认密码">
                    </div>
                    <button type="submit" class="btn btn-success form-control">马上注册</button>
                </form>
            </div>
        </div>
    </div>
@stop
