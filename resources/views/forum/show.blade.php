@extends('app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <div class="media">
                <div class="media-left">
                    <a href="">
                        <img src="{{ $discussion->user->avatar }}" alt="64x64" class="media-object img-circle" style="width: 64px;height: 64px">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        {{ $discussion->title }}
                        @if(Auth::check() && Auth::user()->id == $discussion->user_id)
                        <a class="btn btn-primary btn-lg pull-right" href="/discussions/{{$discussion->id}}/edit" role="button">修改帖子 »</a>
                        @endif
                    </h4>
                    {{ $discussion->user->name }}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main" id="post">
                <div class="blog-post">
                    {!! $html !!}
                </div>
                <hr>
                @foreach($discussion->comments as $comment)
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{$comment->user->avatar}}" alt="64x64" class="media-object img-circle" style="width: 64px; height:64px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{$comment->user->name}}</h4>
                            {{ $comment->body }}
                        </div>
                    </div>
                @endforeach
                <div class="media" v-for="comment in comments">
                    <div class="media-left">
                        <a href="#">
                            <img v-bind:src="comment.avatar" alt="64x64" style="width:64px;height:64px;" class="meida-object img-circle">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">@{{  comment.name }}</h4>
                        @{{ comment.body }}
                    </div>
                </div>
                <hr>
                @if(Auth::check())
                <form action="/comment" method="post" accept-charset="UTF-8" v-on:submit="onSubmitForm">
                    {{csrf_field()}}
                    <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
                <div class="form-group">
                    <textarea name="body" id="body"  cols="30" rows="10" class="form-control" v-model="newComment.body"></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn btn-success pull-right">发表评论</button>
                </div>
            </form>
                @else
                    {!! Session::put('discount_id', $discussion->id) !!}
                    <a href="/user/login" class="btn btn-block btn-success">登录参与评论</a>
                @endif
            </div>
        </div>
    </div>
    {{--<script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        new Vue({
            el:'#post',
            data:{
                comments:[],
                newComment:{
                    name:'{{Auth::user()->name}}' ? '{{Auth::user()->name}}':'',
                    avatar:'{{Auth::user()->avatar}}' ? '{{Auth::user()->avatar}}':'',
                    body:''
                },
                newPost:{
                    discussion_id:'{{$discussion->id}}'?'{{$discussion->id}}':'',
                    user_id:'{{Auth::user()->id}}' ? '{{Auth::user()->id}}':'',
                    body:''
                }
            },
            methods:{
                onSubmitForm:function(e){
                    e.preventDefault();
                    var comment = this.newComment;
                    var post = this.newPost;
                    post.body = comment.body;
                    this.$http.post('/comment',post,function(){
                        this.comments.push(comment);
                    });
                    this.newComment = {
                        name:'{{Auth::user()->name}}' ? '{{Auth::user()->name}}':'',
                        avatar:'{{Auth::user()->avatar}}' ? '{{Auth::user()->avatar}}':'',
                        body:''
                    };
                }
            }
        })
    </script>--}}
@stop
