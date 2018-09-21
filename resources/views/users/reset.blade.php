@extends('resetApp')
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
                <form action="/password/reset" method="POST" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="control-label">重置密码邮箱:</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="请填写正确的邮箱地址">
                    </div>
                    <button type="submit" class="btn btn-success form-control">发送重置密码链接</button>
                </form>
            </div>
        </div>
    </div>
@stop
