@extends('app')
@section('content')
    @foreach($posts->chunk(3) as $row)
    <div class="row">
        @foreach($row as $post)
    <article class="col-md-4">
        <h2>{{ $post->title }}</h2>
        <img src="{{$post->image}}" alt="" width="360">
        <div class="body">
            {{$post->intro}}
        </div>
    </article>
        @endforeach
    </div>
    @endforeach
    { $posts->links() }
@stop
