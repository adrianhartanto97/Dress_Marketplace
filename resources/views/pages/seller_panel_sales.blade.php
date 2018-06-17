@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/icheck/skins/all.css') }}
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
                <a href="#tab_1" data-toggle="tab"> Order Confirmation </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Shipping Confirmation </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                @foreach ($order as $o)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6">
                                {{$o->order_number}}
                            </div>
                            <div class="col-md-6" style="text-align:right">
                                {{$o->user_name}}
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" method = "POST" action="{{ action('Web_Controller\SellerController@approve_order_product') }}" id="form_submit_{{$o->order_number}}">
                            {{ csrf_field() }}
                            <div style="margin-top:-20px">
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Invoice Date :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->invoice_date}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Receiver Name :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->receiver_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Shipping Address :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->address}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Province :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->province_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">City :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->city_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone Number :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->phone_number}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Postal Code :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->postal_code}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Courier :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->courier_name}} {{$o->courier_service}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Note :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$o->note}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Subtotal :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->subtotal_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Shipping Fee :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->shipping_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Total :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($o->total_price)}}</p>
                                    </div>
                                </div>

                                
                                    <input type="hidden" name="transaction_id" value="{{$o->transaction_id}}" >
                                    <input type="hidden" name="store_id" value="{{$o->store_id}}" >
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-advance table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">
                                                        Item </th>
                                                    <th class="hidden-xs" style="text-align:center;">
                                                        Unit Price </th>
                                                    <th class="hidden-xs" style="text-align:center;">
                                                        Qty </th>
                                                    <th class="hidden-xs" style="text-align:center;">
                                                        Subtotal </th>
                                                    <th class="hidden-xs" style="text-align:center;"> </th>
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
                                                        IDR {{number_format($p->price_unit)}}
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                        <b>Total : {{$p->total_qty}}</b> <br>
                                                        @foreach($p->size_info as $sz)
                                                            {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                        @endforeach
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                        IDR {{number_format($p->price_total)}}
                                                    </td>
                                                    <td style="text-align:center;vertical-align:middle;">
                                                        <div class="input-group" style="text-align:center;">
                                                            <div class="icheck-inline" style="text-align:center;">
                                                                <label>
                                                                    <input type="radio" name="status[{{$p->product_id}}]" class="icheck accept" value="1" checked> Accept 
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="status[{{$p->product_id}}]" class="icheck reject" value="2"> Reject 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-3 col-md-offset-9">
                                            <button type="submit" class="btn green btn-lg" form="form_submit_{{$o->order_number}}">Confirm Order</button>
                                        </div>
                                    </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="tab-pane" id="tab_2">
            @foreach ($shipping as $s)
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6">
                                {{$s->order_number}}
                            </div>
                            <div class="col-md-6" style="text-align:right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" method = "POST" action="{{ action('Web_Controller\SellerController@input_receipt_number') }}" id="form_shipping_{{$s->order_number}}">
                            {{ csrf_field() }}
                            <div style="margin-top:-20px">
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Invoice Date :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->invoice_date}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Receiver Name :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->receiver_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Shipping Address :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->address}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Province :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->province_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">City :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->city_name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone Number :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->phone_number}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Postal Code :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->postal_code}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Courier :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->courier_name}} {{$s->courier_service}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Note :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">{{$s->note}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Subtotal :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($s->subtotal_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Shipping Fee :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($s->shipping_price)}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Total :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static">IDR {{number_format($s->total_price)}}</p>
                                    </div>
                                </div>

                                
                                    <input type="hidden" name="transaction_id" value="{{$s->transaction_id}}" >
                                    <input type="hidden" name="store_id" value="{{$s->store_id}}" >
                                   
                                    <div class="panel-group accordion" id="accordion_sh_{{$s->order_number}}">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_sh_{{$s->order_number}}" href="#collapse_sh_{{$s->order_number}}_1"> Product Accepted </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_sh_{{$s->order_number}}_1" class="panel-collapse in">
                                                <div class="panel-body">
                                                    @if ($s->product != "No Product")
                                                    <div class="table-scrollable">
                                                        <table class="table table-striped table-bordered table-advance table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center;">
                                                                        Item </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Unit Price </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Qty </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Subtotal </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($s->product as $p)
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                        <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        IDR {{number_format($p->price_unit)}}
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <b>Total : {{$p->total_qty}}</b> <br>
                                                                        @foreach($p->size_info as $sz)
                                                                            {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        IDR {{number_format($p->price_total)}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @else
                                                    No Product
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- sini -->
                                    @if($s->product != "No Product")
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Input Receipt Number :</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="receipt_number">
                                        </div>
                                    </div>
                                    @endif
                            </div>
                        </form>
                        @if($s->product != "No Product")
                        <div class="row" style="margin-top:20px;text-align:center">
                            <button type="submit" class="btn green" form="form_shipping_{{$s->order_number}}">Submit</button>    
                        </div>
                        @else
                        <div class="row" style="margin-top:20px;text-align:center">
                            <button class="btn green" onclick="finish_order({{$s->transaction_id}}, {{$s->store_id}})">Finish Order</button>
                        </div>
                        @endif
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

        function finish_order(transaction_id, store_id) {
            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/finish_shipping",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    transaction_id : transaction_id,
                    store_id : store_id
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