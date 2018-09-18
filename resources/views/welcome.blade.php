@extends('app')
@section('content')
    @foreach($posts as $post)
    <article class="col-md-4">
        <h2>{{ $post->title }}</h2>
        <img src="{{$post->image}}" alt="" width="360">
        <div class="body">
            {{$post->intro}}
        </div>
    </article>
    @endforeach
@stop
