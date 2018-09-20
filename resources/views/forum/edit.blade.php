@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
                <form action="{{url('discussions/edit/'.$discussion->id)}}" method="POST" accept-charset="UTF-8">
                    {{csrf_field()}}
                <div class="form-group">
                    <label for="title" >标题:</label>
                    <input id="title" name="title" type="text" class="form-control" value="{{$discussion->title}}">
                </div>
                <div class="form-group">
                    <div class="editor">
                        <label for="body">内容:</label>
                        <textarea name="body" id="body"  cols="30" rows="10" class="form-control" >{{ $discussion->body }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">更新帖子</button>
                <form>
            </div>
        </div>
    </div>
@stop
