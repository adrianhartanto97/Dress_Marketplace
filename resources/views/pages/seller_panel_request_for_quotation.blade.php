@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/icheck/skins/all.css') }}
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
@endsection

@section('content')
    @if (session()->has('status') && session()->get('status') == false)
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>{{ session('message')}}</span>
        </div>
    @elseif(session()->has('status') && session()->get('status') == true)
        <div class="alert alert-success">
            <button class="close" data-close="alert"></button>
            <span>{{ session('message')}}</span>
        </div>
    @endif
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Request List </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> My Offer History </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div id="rfq_request_container">
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
                @foreach($rfq_offer_history as $r)
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    {{$r->rfq_offer_id}}
                                </div>
                                <div class="col-md-6" style="text-align:right">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-horizontal">
                                <div style="margin-top:-10px">
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Request ID :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">{{$r->rfq_request_id}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group accordion" id="accordion_rfq_h_{{$r->rfq_offer_id}}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_h_{{$r->rfq_offer_id}}" href="#collapse_rfq_h_{{$r->rfq_offer_id}}_1"> {{$r->item_name}} </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_rfq_h_{{$r->rfq_offer_id}}_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <div class="form-horizontal">
                                                <div style="margin-top:-10px">
                                                </div>
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Description :</label>
                                                        <div class="col-md-7">
                                                            <p class="form-control-static">{{$r->request_description}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Qty :</label>
                                                        <div class="col-md-7">
                                                            <p class="form-control-static">{{$r->qty}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Date Expired :</label>
                                                        <div class="col-md-7">
                                                            <p class="form-control-static">{{$r->request_expired}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Budget per Unit :</label>
                                                        <div class="col-md-7">
                                                            <p class="form-control-static">IDR {{number_format($r->budget_unit_min)}} - IDR {{number_format($r->budget_unit_max)}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Photo :</label>
                                                        <div class="col-md-3">
                                                            <a href="{{asset('/public/storage/').'/'.$r->request_photo->file_path}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                                                <img class="img-responsive" src="{{asset('/public/storage/').'/'.$r->request_photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-horizontal">
                                <div style="margin-top:-10px">
                                </div>
                                <div class="form-body">
                                    <h3 class="form-section">My Offer</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Description :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">{{$r->description}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Price per Unit :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">IDR {{number_format($r->price_unit)}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Weight per Unit (gr) :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">{{$r->weight_unit}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Photo :</label>
                                        <div class="col-md-3">
                                            <a href="{{asset('/public/storage/').'/'.$r->offer_photo->file_path}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                                <img class="img-responsive" src="{{asset('/public/storage/').'/'.$r->offer_photo->file_path}}" width="90%" style="margin: 0 auto;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/icheck/icheck.min.js')}}
    {{HTML::script('public/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
    {{HTML::script('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
        $(document).ready(function(){
            $('input.accept').iCheck({
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            $('input.reject').iCheck({
                radioClass: 'iradio_square-red',
                increaseArea: '20%' // optional
            });
        });

       $( document ).ready(function() {
            App.blockUI({
                boxed: true
            });
            $.ajax({
                url: "http://localhost/dress_marketplace/rfq_request_list",
                data : {
                    
                },
                dataType: 'html',
                success: function(html) {
                    $('#rfq_request_container').html(html);
                    App.unblockUI();
                }
            });
        });
    </script>
@endsection