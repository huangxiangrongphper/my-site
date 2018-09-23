@extends('app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <h2>欢迎来到 PHP技术问答 社区🖖
                <a class="btn btn-danger btn-lg pull-right" href="/questions/create" role="button">发布新的问题 »</a>
            </h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
            @foreach($questions as $question)
                <div class="media">
                    <div class="media-left">
                        <a href="">
                            <img src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}" class="media-object img-circle" style="width: 64px;height: 64px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/questions/{{ $question->id }}">
                                {{ $question->title }}
                            </a>
                        </h4>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <style>
        .panel-body img {
            width:100%;
        }
    </style>
@stop
