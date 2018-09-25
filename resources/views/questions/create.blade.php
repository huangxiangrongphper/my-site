<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>hellohxr.cn</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apiToken" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/select2.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/jquery.Jcrop.css">
    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/jquery.Jcrop.min.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="/js/select2.min.js"></script>
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
               <div class="panel panel-default">
                   <div class="panel-heading">发布问题</div>
                   <div class="panel-body">
                       <form action="/questions" method="post">
                           {!! csrf_field() !!}
                           <div class="form-group{{ $errors->has('title') ? 'has-error' : '' }}">
                               <label for="title">标题</label>
                               <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="标题" id="title">
                               @if ($errors->has('title'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('title') }}</strong>
                                   </span>
                               @endif
                           </div>
                           <div class="form-group">
                               <select name="topics[]" class="js-example-placeholder-multiple js-data-example-ajax form-control" multiple="multiple">
                               </select>
                           </div>
                           <div class="form-group{{ $errors->has('body') ? 'has-error' : '' }}">
                               <label for="body">描述</label>
                               <script id="container" name="body" style="height: 200px" type="text/plain">
                                   {!! old('body') !!}
                               </script>
                               @if ($errors->has('body'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('body') }}</strong>
                                   </span>
                               @endif
                           </div>
                       <button class="btn btn-success pull-right" type="submit">发布问题</button>
                       </form>

                   </div>
               </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->
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
   $(document).ready(function () {
       function formatTopic (topic) {

           return "<div class='select2-result-repository clearfix'>" +

           "<div class='select2-result-repository__meta'>" +

           "<div class='select2-result-repository__title'>" +

           topic.name ? topic.name : "Laravel"   +

               "</div></div></div>";

       }


       function formatTopicSelection (topic) {

           return topic.name || topic.text;

       }


       $(".js-example-placeholder-multiple").select2({

           tags: true,

           placeholder: '选择相关话题',

           minimumInputLength: 2,

           ajax: {

               url: '/api/topics',

               dataType: 'json',

               delay: 250,

               data: function (params) {

                   return {

                       q: params.term

                   };

               },

               processResults: function (data, params) {

                   return {

                       results: data

                   };

               },

               cache: true

           },

           templateResult: formatTopic,

           templateSelection: formatTopicSelection,

           escapeMarkup: function (markup) { return markup; }

       });
   });
    </script>
</body>
</html>
