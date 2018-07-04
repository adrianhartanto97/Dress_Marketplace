@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
@endsection

@section('content')
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Upline Partner </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Downline Partner </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="tabbable-custom">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab"> Add Partner </a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"> My Upline Partners </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
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
                            @foreach($upline_req as $o)
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                {{$o->order_number}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-horizontal">
                                            <div style="margin-top:-20px">
                                            </div>
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Store Name :</label>
                                                    <div class="col-md-7">
                                                        <p class="form-control-static">{{$o->store_name}}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Invoice Date :</label>
                                                    <div class="col-md-7">
                                                        <p class="form-control-static">{{$o->invoice_date}}</p>
                                                    </div>
                                                </div>
                                                <div class="panel-group accordion" id="accordion_{{$o->order_number}}">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_{{$o->order_number}}" href="#collapse_{{$o->order_number}}_1"> Products </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapse_{{$o->order_number}}_1" class="panel-collapse in">
                                                            <div class="panel-body">
                                                                <div class="table-scrollable">
                                                                    <table class="table table-striped table-bordered table-advance table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align:center;">
                                                                                    Item </th>
                                                                                <th class="hidden-xs" style="text-align:center;">
                                                                                 </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($o->product as $p)
                                                                            <tr>
                                                                                <td>
                                                                                    <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                                    <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                                                                </td>
                                                                                <td style="text-align:center;vertical-align:middle;">
                                                                                    @if($p->has_partnership)
                                                                                        <h4>Status : Waiting Approval</h4>
                                                                                    @else
                                                                                        <button type="button" class="btn blue" data-toggle="modal" href="#modal_{{$o->order_number}}_{{$p->product_id}}">Request Partnership</button>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            @foreach($o->product as $p)
                                                            <div class="modal fade in" id="modal_{{$o->order_number}}_{{$p->product_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                            <h4 class="modal-title">Request Partnership</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <div><h4>{{$o->store_name}}</h4></div>
                                                                                    
                                                                                        <div class="table-scrollable">
                                                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>
                                                                                                            <i class="fa fa-cart-plus"></i> Qty </th>
                                                                                                        <th class="hidden-xs">
                                                                                                            <i class="fa fa-money"></i> Price </th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                @foreach ($p->price as $pp)
                                                                                                <tr>
                                                                                                    <td class="highlight">
                                                                                                        @if ($pp->qty_max != "max")
                                                                                                            {{$pp->qty_min}} - {{$pp->qty_max}}
                                                                                                        @else
                                                                                                            >= {{$pp->qty_min}}
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td class="hidden-xs"> IDR {{$pp->price}} </td>
                                                                                                </tr>
                                                                                                @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                </div>

                                                                                <div class="col-md-1">
                                                                                </div>

                                                                                <div class="col-md-7">
                                                                                    <h4>Your Request</h4>
                                                                                    <form class="form-horizontal" action="{{ action('Web_Controller\SellerController@submit_request_partnership') }}" id="form_{{$o->order_number}}_{{$p->product_id}}" method="POST">
                                                                                        {{ csrf_field() }}
                                                                                        <input type="hidden" name="product_id" value="{{$p->product_id}}">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-md-5">Min Order
                                                                                                <span class="required"> * </span>
                                                                                            </label>
                                                                                            <div class="col-md-4">
                                                                                                <input type="text" class="form-control" name="min_order"/>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-md-3">Price Range
                                                                                                <span class="required"> * </span>
                                                                                            </label>
                                                                                            <div class="col-md-12">
                                                                                                <div id="mt-repeater_{{$o->order_number}}_{{$p->product_id}}">
                                                                                                    <div data-repeater-list="price_range">
                                                                                                        <div data-repeater-item class="row">
                                                                                                            <div class="col-md-3">
                                                                                                                <label class="control-label">Qty (Min)</label>
                                                                                                                <input type="text" class="form-control qty_min" name="qty_min"> </div>
                                                                                                            <!-- <div class="col-md-1">
                                                                                                                <label class="control-label"> </label>
                                                                                                                <p class="form-control-static">-</p>
                                                                                                            </div> -->
                                                                                                            <div class="col-md-4">
                                                                                                                <label class="control-label">Qty (Max)</label>
                                                                                                                <div class="input-group">
                                                                                                                    <input type="text" class="form-control qty_max" name="qty_max">
                                                                                                                    <span class="input-group-btn">
                                                                                                                        <button class="btn blue max_button" type="button">Max</button>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <label class="control-label">Price</label>
                                                                                                                <input type="text" class="form-control" name="price"> 
                                                                                                            </div>
                                                                                                            <div class="col-md-1">
                                                                                                                <label class="control-label">&nbsp;</label>
                                                                                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
                                                                                                                    <i class="fa fa-close"></i>
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <hr>
                                                                                                    <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
                                                                                                        <i class="fa fa-plus"></i> Add Price Range</a>
                                                                                                    <br>
                                                                                                    <br> 
                                                                                                </div>
                                                          
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn green" form="form_{{$o->order_number}}_{{$p->product_id}}">Send Confirmation</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- --></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            b
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab_2">
                <div class="tabbable-custom">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_2_1" data-toggle="tab"> Partner Requests </a>
                        </li>
                        <li>
                            <a href="#tab_2_2" data-toggle="tab"> My Downline Partners </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_2_1">
                            c
                        </div>
                        <div class="tab-pane" id="tab_2_2">
                            d
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/select2/js/select2.full.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{HTML::script('public/global/plugins/jquery-repeater/jquery.repeater.js')}}
    {{HTML::script('public/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    {{ HTML::script('public/pages/scripts/components-bootstrap-select.min.js') }}
    {{ HTML::script('public/js/seller_panel_product.js') }}
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
        jQuery(document).ready(function() {
            // $('.mt-repeater').each(function(){
            //     $(this).repeater({
        	// 		show: function () {
	        //         	$(this).slideDown();
            //             $('.max_button').click(function() {
            //                 $(this).parent().parent().find("input").val("max");
            //             });
                        
            //             var current = parseInt($(this).prev().find("input.qty_max").val()) + 1;
            //             $(this).find("input.qty_min").val(current);
		    //         },

		    //         hide: function (deleteElement) {
		    //             if(confirm('Are you sure you want to delete this price range?')) {
		    //                 $(this).slideUp(deleteElement);
		    //             }
		    //         },

		    //         ready: function (setIndexes) {

		    //         }

        	// 	});
        	// });
            @foreach($upline_req as $o)
                @foreach($o->product as $p)
                     $('#mt-repeater_{{$o->order_number}}_{{$p->product_id}}').repeater({
                            show: function () {
                                $(this).slideDown();
                                $('.max_button').click(function() {
                                    $(this).parent().parent().find("input").val("max");
                                });
                                
                                var current = parseInt($(this).prev().find("input.qty_max").val()) + 1;
                                $(this).find("input.qty_min").val(current);
                            },

                            hide: function (deleteElement) {
                                if(confirm('Are you sure you want to delete this price range?')) {
                                    $(this).slideUp(deleteElement);
                                }
                            },

                            ready: function (setIndexes) {

                            }

                        });
                @endforeach
            @endforeach

            $( "input[name='min_order']" ).on("change paste keyup", function() {
                min_order = $(this).val();
                $( "input[name='price_range[0][qty_min]']" ).val(min_order).attr('readonly',true);
            });
        });
    </script>
@endsection