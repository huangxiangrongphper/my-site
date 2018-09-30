@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>
                    <div class="panel-body">
                        @foreach($messages as $messageGroup)
                        <div class="media {{ $messageGroup->first()->shouldAddUnreadClass() ? 'unread' : '' }}">
                            <div class="media-left">
                                <a href="#">
                                    @if(Auth::id() == $messageGroup->last()->from_user_id)
                                    <img src="{{ $messageGroup->last()->toUser->avatar }}" alt="" class="media-object img-circle" style="width: 32px;height: 32px">
                                    @else
                                        <img src="{{ $messageGroup->last()->fromUser->avatar }}" alt="" class="media-object img-circle" style="width: 32px;height: 32px">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="#">
                                    @if(Auth::id() == $messageGroup->last()->from_user_id)
                                    {{ $messageGroup->last()->toUser->name }}
                                    @else
                                    {{ $messageGroup->last()->fromUser->name }}
                                    @endif
                                    </a>
                                </h4>
                            </div>
                            <p>
                                <a href="/inbox/{{ $messageGroup->first()->dialog_id }}">
                                    {{ $messageGroup->first()->body }}
                                </a>
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
