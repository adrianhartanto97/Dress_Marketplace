@extends('pages.admin.admin_panel_layout')

@section('content')
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Active User </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> NonActive User </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <ul class="list-group">
                    @foreach($active_user as $u)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <img alt="" class="img-circle" src="{{asset('/public/storage').'/'.$u->avatar}}" style="width:40px;" /> 
                                {{$u->full_name}}
                            </div>
                            <div class="col-md-8">
                                <a class="btn green" style="margin:0 auto;" onclick="nonactive({{$u->user_id}})"> Non Active </a>
                            </div>
                         </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-pane" id="tab_2">
            <ul class="list-group">
                    @foreach($nonactive_user as $u)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <img alt="" class="img-circle" src="{{asset('/public/storage').'/'.$u->avatar}}" style="width:40px;" /> 
                                {{$u->full_name}}
                            </div>
                            <div class="col-md-8">
                                <a class="btn green" style="margin:0 auto;" onclick="active({{$u->user_id}})"> Active </a>
                            </div>
                         </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function nonactive(user_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/set_nonactive_user",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    user_id : user_id
                },
                async: false,
                success : function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }

        function active(user_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/set_active_user",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    user_id : user_id
                },
                async: false,
                success : function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Error occured');
                }
            });
        }
    </script>
@endsection