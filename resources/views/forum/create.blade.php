@extends('app')
@section('content')
    @include('editor::head')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error  }}</li>
                        @endforeach
                    </ul>
                @endif
                <form action="/discussions/store" method="POST" accept-charset="UTF-8">
                    {{csrf_field()}}
                     @include('forum.form')
                    <div>
                        <button type="submit" class="btn btn-primary pull-right">发表帖子</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
