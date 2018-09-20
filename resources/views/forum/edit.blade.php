@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error  }}</li>
                        @endforeach
                    </ul>
                @endif
                <form action="/discussions/{{$discussion->id}}/edit"  method="POST" accept-charset="UTF-8">
                    {{csrf_field()}}
                <div class="form-group">
                    <label for="title" >标题:</label>
                    <input id="title" name="title" type="text" class="form-control" value="{{$discussion->title}}">
                </div>
                <div class="form-group">
                    <div class="editor">
                        <textarea name="body" id="myEditor"  cols="30" rows="10" class="form-control" >{{ $discussion->body }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">更新帖子</button>
             </form>
            </div>
        </div>
    </div>
@stop
