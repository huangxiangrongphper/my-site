<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>hellohxr.cn</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apiToken" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">HELLOHXR.CN</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">首页</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li><a id="drop1" type="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/user/avatar"> <i class="fa fa-user"></i> 更换头像</a></li>
                            <li><a href="#"> <i class="fa fa-cog"></i> 更换密码</a></li>
                            <li><a href="/about"> <i class="fa fa-heart"></i> 个人中心</a></li>
                            <li role="separator" class="divider"></li>
                            <li> <a href="/logout">  <i class="fa fa-sign-out"></i> 退出登录</a></li>
                        </ul>
                    </li>
                    <li><img src="{{Auth::user()->avatar}}" class="img-circle" width="50" alt=""></li>
                @else
                    <li><a href="/user/login">登 录</a></li>
                    <li><a href="/user/register">注 册</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
    @include('vendor.ueditor.assets')
    <div class="container" id="app" >
        <div class="row">
            <div class="col-md-8 col-md-offset-1" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                        @if($question->topics)
                        @foreach( $question->topics as $topic)
                            <a class="topic" href="">{{ $topic->name }}</a>
                        @endforeach
                        @endif
                    </div>
                    <div class="panel-body content">
                        {!! $question->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="">
                                        {{$question->user->name}}
                                    </a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count"> {{$question->user->questions_count}} </div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count"> {{ $question->user->answers_count }} </div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注着</div>
                                    <div class="statics-count"> {{ $question->user->followers_count }} </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::check())
                        <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                        @else
                        <a href="{{url('user/login')}}" class="btn btn-default">关注他</a>
                        @endif
                        @if(Auth::check())
                        <send-message user="{{ $question->user_id }}"></send-message>
                        @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{url('user/login')}}" class="btn btn-default">发送私信</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading question-follow">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body" >
                        @if(Auth::check())
                        <question-follow-button question="{{$question->id}}"></question-follow-button>
                        @else
                            <a href="{{url('user/login')}}" class="btn btn-default">关注该问题</a>
                        @endif
                        <a href="#editor" class="btn btn-primary pull-right">撰写答案</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1" >
               <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $question->answers_count }} 个答案
                </div>
                <div class="panel-body content">

                    @foreach($question->answers as $answers)
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img src="{{ $question->user->avatar }}" alt="64x64" class="media-object img-circle" style="width: 36px;height: 36px">
                                </a>
                            </div>
                            <div class="media-body" >
                                <h4 class="media-heading">
                                    <a href="/user/{{ $answers->user->name }}">
                                        {{ $answers->user->name }}
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;点赞👍  <user-voted-button answer="{{$answers->id}}" count="{{$answers->votes_count}}"></user-voted-button>
                                </h4>
                                     {!! $answers->body !!}
                            </div>
                        </div>
                    @endforeach
                        @if(Auth::check())
                        <form action="/questions/{{$question->id}}/answer" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <script id="container" name="body" style="height: 120px;" type="text/plain">
                                    {!! old('body') !!}
                                </script>
                                @if ($errors->has('body'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                        @endif
                            </div>
                                    <button class="btn btn-success pull-right" type="submit">提交答案</button>
                                    </form>
                        @else
                           <a href="{{ url('user/login') }}" class="btn btn-success btn-block">登录提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        var ue = UE.getEditor('container',{
                toolbars: [
                    ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            }
        );
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
</body>
</html>
<script src="/js/app.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

