@extends('app')
@section('content')
    <div class="container">
        <div class="container">
            @include('flash::message')
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2" >
                <div class="panel panel-default">
                    <div class="panel-heading">个人中心</div>
                    <div class="panel-body">
                        @foreach($user->notifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#flash-overlay-modal').modal();
    </script>
@stop
