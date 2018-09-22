@extends('app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
               <div class="panel panel-defau">
                   <div class="panel-heading">发布问题</div>
                   <div class="panel-body">
                       <script id="container" name="body" type="text/plain"></script>

                   </div>
               </div>
            </div>
        </div>
    </div>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
@stop
