@extends('pages.admin.admin_panel_layout')

@section('content')
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Active Product</a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Report Product </a>
            </li>
            <li>
                <a href="#tab_3" data-toggle="tab"> NonActive Product </a>
            </li>
        </ul>
        <div id="info">
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div id="product_active_container"></div>
            </div>
            <div class="tab-pane" id="tab_2">
                @foreach ($product_report as $w)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6" style="text-decoration:none; color: white;">
                                <a href="{{url('/product_detail')}}/{{$w->product_id}}" target="_blank">{{$w->name}}</a>
                            </div>
                            <div class="col-md-6" style="text-align:right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="panel-group accordion" id="accordion_{{$w->product_id}}">
                            @foreach($w->report as $r)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_{{$w->product_id}}" href="#collapse_{{$r->report_id}}"> {{$r->full_name}} </a>
                                    </h4>
                                </div>
                                <div id="collapse_{{$r->report_id}}" class="panel-collapse in">
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Issue :</label>
                                                <div class="col-md-7">
                                                    <p class="form-control-static">{{$r->issue}}</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Comment :</label>
                                                <div class="col-md-7">
                                                    <p class="form-control-static">{{$r->comment}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div style="text-align:center">
                            <button class="btn red" onclick="nonactive({{$w->product_id}})">Non Active</button>
                        </div>
                    </div>
                </div>
                @endforeach 
            </div>
            <div class="tab-pane" id="tab_3">
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="row">
                            @foreach ($nonactive_product as $w)
                            
                            <a href="{{url('/product_detail')}}/{{$w->product_id}}"  style="text-decoration:none;">
                            <div class="col-lg-3 col-xs-6 col-sm-4 col-md-3 center">
                                <div class="thumbnail" style="text-align: center;">
                                    <img src="{{asset('/public/storage/').'/'.$w->product_photo}}" alt="" style="width: 100%; height: 170px;">
                                        <div style="height: 60px;">
                                                <h4 class="black">
                                                @if(strlen($w->product_name) > 60 )
                                                {{substr($w->product_name,0,60)."..."}}
                                                @else
                                                {{$w->product_name}}
                                                @endif
                                            </h4>
                                        </div>
                                        
                                    <b>{{$w->store_name}}</b>
                                </div>
                            </div>
                            </a>
                            @endforeach 

                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function accept(product_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/accept_product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id : product_id
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

        function reject(product_id) {
            var reject_note = $('textarea#reject_note_'+product_id).val();
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/reject_product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id : product_id,
                    reject_comment : reject_note
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

        function nonactive(product_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/admin/set_nonactive_product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    product_id : product_id
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

        $( document ).ready(function() {
            App.blockUI({
                boxed: true
            });
            $.ajax({
                url: "http://localhost/dress_marketplace/admin/product_active",
                data : {
                    
                },
                dataType: 'html',
                success: function(html) {
                    $('#product_active_container').html(html);
                    App.unblockUI();
                }
            });
        });
    </script>
@endsection