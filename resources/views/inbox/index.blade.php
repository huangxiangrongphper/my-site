@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
                <div class="panel panel-default">
                    <div class="panel-heading">私信</div>
                    <div class="panel-body">
                        @foreach($messages as $key => $messageGroup)
                            <div class="media-left">
                                <a href="#">
                                    @if(Auth::id() == $key)
                                    <img src="{{ $messageGroup->first()->fromUser->avatar }}" alt="" class="media-object img-circle" style="width: 32px;height: 32px">
                                    @else
                                        <img src="{{ $messageGroup->first()->toUser->avatar }}" alt="" class="media-object img-circle" style="width: 32px;height: 32px">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="#">
                                    @if(Auth::id() == $key)
                                    {{ $messageGroup->first()->fromUser->name }}
                                    @else
                                    {{ $messageGroup->first()->toUser->name }}
                                    @endif
                                    </a>
                                </h4>
                            </div>
                            <p>
                                <a href="/inbox/{{ $messageGroup->last()->dialog_id }}">
                                    {{ $messageGroup->last()->body }}
                                </a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
