@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
                <div class="panel panel-default">
                    <div class="panel-heading">对话列表</div>
                    <div class="panel-body">
                        <form action="/inbox/{{$dialogId}}/store" method="post">
                            {{csrf_field()}}
                            <div class="form-group pull-right">
                                <textarea name="body" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">发送私信</button>
                            </div>
                        </form>
                        <div class="messages-list">
                            @foreach($messages as $message)
                                <div class="media-left">
                                    <a href="#">
                                        <img src="{{ $message->fromUser->avatar }}" alt="" class="media-object img-circle" style="width: 32px;height: 32px">

                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            {{ $message->fromUser->name }}
                                        </a>
                                    </h4>
                                </div>
                                <p>
                                    {{ $message->body }} <span class="pull-right">{{ $message->created_at->format('Y-m-d H:i:s') }}</span>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
