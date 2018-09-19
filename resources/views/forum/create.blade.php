@extends('app')
@section('content')
    {{--@include('editor::head')--}}
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
                <form action="/discussions" method="POST" accept-charset="UTF-8">
                     @include('forum.form')
                    <div>
                        <button type="submit" class="btn btn-primary pull-right">发表帖子</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
