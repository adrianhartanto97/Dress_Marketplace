@extends('layout')

@section('css')
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}
@endsection

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <div class="row" style="padding:0px 10px;">
            @include('layout.user_sidebar',['login_info' => $login_info])
            <div class="col-xs-12 col-sm-9 col-md-10">
                @if (session()->has('status') && session()->get('status') == false)
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>{{ session('message')}}</span>
                    </div>
                @elseif (session()->has('status') && session()->get('status') == true)
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button>
                        <span>{{ session('message')}}</span>
                    </div>
                @endif
                <div class="tabbable-custom">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_1" data-toggle="tab"> Payment </a>
                        </li>
                        <li>
                            <a href="#tab_2" data-toggle="tab"> Order Status </a>
                        </li>
                        <li>
                            <a href="#tab_3" data-toggle="tab"> Receipt Confirmation </a>
                        </li>
                        <li>
                            <a href="#tab_4" data-toggle="tab"> Review & Rating </a>
                        </li>
                        <li>
                            <a href="#tab_5" data-toggle="tab"> Transaction History </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            @foreach ($purchase_payment as $p)
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <!-- <div class="caption"> -->
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                Invoice Number {{$p->transaction_id}} (Status : {{$p->payment_status}})
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                {{$p->invoice_date}}
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                </div>
                                <div class="portlet-body">
                                    @if (session()->has('status') && session()->get('status') == false)
                                        <div class="alert alert-danger">
                                            <button class="close" data-close="alert"></button>
                                            <span>{{ session('message')}}</span>
                                        </div>
                                    @elseif (session()->has('status') && session()->get('status') == true)
                                        <div class="alert alert-success">
                                            <button class="close" data-close="alert"></button>
                                            <span>{{ session('message')}}</span>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4>Invoice Grand Total : IDR {{number_format($p->invoice_grand_total)}}<h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">Status : {{$p->payment_status}}</div>
                                            <div class="row" style="margin-top:5px;">
                                                <button class="btn blue" data-toggle="modal" href="#modal_{{$p->transaction_id}}">Confirm Payment</button>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach($p->order_store as $store)
                                    <div class="portlet box green-meadow" style="margin-top:20px;">

                                        <div class="portlet-title">

                                                <div class="row" style="margin-top:10px;">
                                                    <div class="col-md-6">
                                                        {{$store->order_number}}
                                                    </div>
                                                    <div class="col-md-6" style="text-align:right">
                                                        {{$store->store_name}}
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="portlet-body">
                                            <p>
                                                Shipping Address : {{$store->address}} <br>
                                                Note : {{$store->note}}
                                            </p>
                                            <div class="panel-group accordion" id="accordion_{{$store->store_id}}">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_{{$store->store_id}}" href="#collapse_{{$store->store_id}}_1"> Products </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_{{$store->store_id}}_1" class="panel-collapse in">
                                                        <div class="panel-body">
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
                                                                        @foreach ($store->product as $pr)
                                                                        <tr>
                                                                        <td>
                                                                                <img src="{{asset('/public/storage/').'/'.$pr->product_photo}}" width="80px" style="margin: 0 auto;">
                                                                                <span style="margin-left:20px;"></span>
                                                                                <b><a href="product_detail/{{$pr->product_id}}">{{$pr->product_name}}</a></b>
                                                                        </td>
                                                                        <td style="text-align:center;vertical-align:middle;">
                                                                                IDR {{number_format($pr->price_unit)}}
                                                                        </td>
                                                                        <td style="text-align:center;vertical-align:middle;">
                                                                                <b>Total : {{$pr->total_qty}}</b> <br>
                                                                                @foreach($pr->size_info as $sz)
                                                                                    {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                                                @endforeach
                                                                        </td>
                                                                        <td style="text-align:center;vertical-align:middle;">
                                                                                IDR {{number_format($pr->price_total)}}
                                                                        </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#collapse_{{$store->store_id}}_1').collapse('hide');
                                            </script>
                                            <p style="font-size:16px; line-height:24px;">
                                                Sub Total : IDR {{number_format($store->subtotal_price)}}<br>
                                                Shipping Fee : IDR {{number_format($store->shipping_price)}}<br>
                                                Total : IDR {{number_format($store->total_price)}}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal fade in" id="modal_{{$p->transaction_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Payment Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div style="margin-top:-20px">
                                            <h3>Invoice Number {{$p->transaction_id}}</h3>
                                            <h4>Total : IDR {{number_format($p->invoice_grand_total)}}</h4>
                                            </div>
                                            <form action="{{ action('Web_Controller\AppController@confirm_payment') }}" class="form-horizontal" method="POST" style="margin-top:20px;" id="form_{{$p->transaction_id}}">
                                                {{ csrf_field() }}
                                                <div class="form-body">
                                                    <input type="hidden" name="transaction_id" value="{{$p->transaction_id}}">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Date
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" name="date" value="{{$p->date}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Transfer to
                                                        <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="company_bank_id" value="{{$p->company_bank_id}}">
                                                                @foreach($bank as $b)
                                                                <option value="{{$b->bank_id}}">{{$b->bank_name}} {{$b->account_number}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Amount
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="amount" value="@if(!$p->amount){{$p->invoice_grand_total}}@else{{$p->amount}}@endif"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Your Bank
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="sender_bank" placeholder="BCA" value="{{$p->sender_bank}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Your Bank Account Number
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="sender_account_number" placeholder="xxxxxxxxxx" value="{{$p->sender_account_number}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Your Name in Bank Account
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="sender_name" placeholder="your name" value="{{$p->sender_name}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Note
                                                        </label>
                                                        <div class="col-md-7">
                                                            <textarea type="text" class="form-control" name="note">{{$p->note}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn green" form="form_{{$p->transaction_id}}">Send Confirmation</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="tab_2">
                            @foreach ($order as $o)
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-6">
                                            {{$o->order_number}}
                                        </div>
                                        <div class="col-md-6" style="text-align:right">
                                            {{$o->store_name}}
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="portlet-body">
                                    <form action="#" class="form-horizontal">
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
                                                                                Unit Price </th>
                                                                            <th class="hidden-xs" style="text-align:center;">
                                                                                Qty </th>
                                                                            <th class="hidden-xs" style="text-align:center;">
                                                                                Subtotal </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($o->product_ordered as $p)
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#collapse_{{$o->order_number}}_1').collapse('hide');
                                            </script>
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

                                            
                                        </div>
                                    </form>

                                    
                                    <div class="row" style="text-align:center">
                                        <div class="col-md-8 col-md-offset-2">
                                            @if ($o->order_status == 'Waiting Seller Response')
                                                <h3>Status : {{$o->order_status}}</h3>
                                            @else
                                            <div class="panel-group accordion" id="accordion_app_{{$o->order_number}}">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_app_{{$o->order_number}}" href="#collapse_app_{{$o->order_number}}_1"> Status : {{$o->order_status}} </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_app_{{$o->order_number}}_1" class="panel-collapse in">
                                                        <div class="panel-body">
                                                            <h4>Accepted</h4>
                                                            @if (sizeof($o->product_accepted) != 0)
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
                                                                        @foreach ($o->product_accepted as $p)
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
                                                            <h5>No Product Accepted</h5>
                                                            @endif

                                                            <h4 style="margin-top:20px;">Rejected</h4>
                                                            @if (sizeof($o->product_rejected) != 0)
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
                                                                        @foreach ($o->product_rejected as $p)
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
                                                            <h5>No Product Rejected</h5>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#collapse_app_{{$o->order_number}}_1').collapse('hide');
                                            </script>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>   

                            @endforeach
                        </div>
                        <div class="tab-pane" id="tab_3">
                        @foreach ($shipping as $o)
                            @if (session()->has('status') && session()->get('status') == false)
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ session('message')}}</span>
                                </div>
                            @elseif (session()->has('status') && session()->get('status') == true)
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ session('message')}}</span>
                                </div>
                            @endif
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-6">
                                            {{$o->order_number}}
                                        </div>
                                        <div class="col-md-6" style="text-align:right">
                                            {{$o->store_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form method="POST" action="{{action ('Web_Controller\AppController@confirm_receipt') }}" class="form-horizontal">
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
                                                <label class="control-label col-md-3">Receipt Number :</label>
                                                <div class="col-md-7">
                                                    <p class="form-control-static">{{$o->receipt_number}}</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="transaction_id" value="{{$o->transaction_id}}">
                                            <input type="hidden" name="store_id" value="{{$o->store_id}}">
                                            <div class="panel-group accordion" id="accordion_{{$o->order_number}}_sh">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_{{$o->order_number}}_sh" href="#collapse_{{$o->order_number}}_1_sh"> Products </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_{{$o->order_number}}_1_sh" class="panel-collapse in">
                                                        <div class="panel-body">
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
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#collapse_{{$o->order_number}}_1_sh').collapse('hide');
                                            </script>

                                        </div>
                                        <div class="form-actions">
                                            <div class="row" style="text-align:center;">
                                                    <button type="submit" class="btn green btn-lg">I have Received</button> 
                                            </div>
                                        </div>
                                    </form>

                                    
                                </div>
                            </div>   
                        @endforeach
                        </div>

                        <div class="tab-pane" id="tab_4">
                            @if (session()->has('status') && session()->get('status') == false)
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ session('message')}}</span>
                                </div>
                            @elseif (session()->has('status') && session()->get('status') == true)
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ session('message')}}</span>
                                </div>
                            @endif
                            @foreach ($review_rating as $o)
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                {{$o->order_number}}
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                {{$o->store_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <form method="POST" action="{{action ('Web_Controller\AppController@submit_review_rating') }}">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{asset('/public/storage/').'/'.$o->store_photo}}" width="200px" height="200px" style="margin: 0 auto;">
                                            </div>
                                            <div class="col-md-9">
                                                <div style="font-size:26px;">{{$o->store_name}}</div>
                                                <h4>Accepted : {{$o->accepted}}</h4>
                                                <h4>Rejected : {{$o->rejected}}</h4>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-12">
                                                How many stars would you rate it ?
                                            </div>
                                            <div class="col-md-12">
                                                <div id="store_div_{{$o->order_number}}"></div>
                                                <input type="hidden" name="transaction_id" value="{{$o->transaction_id}}">
                                                <input type="hidden" name="store_id" value="{{$o->store_id}}">
                                                <input type="hidden" name="store_rating" id="store_rating_{{$o->transaction_id}}_{{$o->store_id}}" value="0">
                                            </div>
                                            <script>
                                                $("#store_div_{{$o->order_number}}").starRating({
                                                    totalStars: 5,
                                                    useFullStars: true,
                                                    disableAfterRate: false,
                                                    callback: function(currentRating, $el){
                                                        //alert('rated ' + currentRating);
                                                        $("#store_rating_{{$o->transaction_id}}_{{$o->store_id}}").val(currentRating);
                                                    }
                                                });
                                            </script>
                                        </div>
                                        <hr style="background-color: grey; height: 1px; border: 0;">
                                        @foreach($o->product as $p)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="120px" height="120px" style="margin: 0 auto;">
                                                </div>
                                                <div class="col-md-10">
                                                    <div style="font-size:20px;">{{$p->product_name}}</div>
                                                    <h5>How many stars would you rate it ?</h5>
                                                    <div id="product_div_{{$o->transaction_id}}_{{$p->product_id}}"></div>
                                                    <input type="hidden" name="product_rating[{{$p->product_id}}]" id="product_rating_{{$o->transaction_id}}_{{$p->product_id}}" value="0">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-md-12">
                                                    <textarea type="text" class="form-control" name="product_review[{{$p->product_id}}]" placeholder="Write your review about the product here" required></textarea>
                                                </div>
                                            </div>
                                            <script>
                                                $("#product_div_{{$o->transaction_id}}_{{$p->product_id}}").starRating({
                                                    totalStars: 5,
                                                    starSize: 25,
                                                    useFullStars: true,
                                                    disableAfterRate: false,
                                                    callback: function(currentRating, $el){
                                                        //alert('rated ' + currentRating);
                                                        $("#product_rating_{{$o->transaction_id}}_{{$p->product_id}}").val(currentRating);
                                                    }
                                                });
                                            </script>
                                        @endforeach
                                        <div style="margin-top:15px;text-align:center">
                                            <button type="submit" class="btn blue">
                                                Submit
                                            </button>
                                        </div>
                                        </form>
                                    </div>
                                </div>   
                            @endforeach
                        </div>

                        <div class="tab-pane" id="tab_5">
                            <div id="transaction_history_container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{HTML::script('public/star-rating-svg-master/src/jquery.star-rating-svg.js')}}{{HTML::script('public/global/plugins/moment.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}

    <script>
        @foreach ($purchase_payment as $p)
            $( "#form_{{$p->transaction_id}}" ).validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                company_bank_id: {
                    required: true
                },
                amount: {
                    required: true,
                    number : true
                },
                sender_bank: {
                    required: true
                },
                sender_account_number: {
                    required: true
                },
                sender_name: {
                    required: true
                },
                date: {
                    required: true
                },
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                    var cont = $(element).parent('.input-group');
                    if (cont.size() > 0) {
                        cont.after(error);
                    } else {
                        element.after(error);
                    }
                },

                highlight: function (element) { // hightlight error inputs

                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
        });
        @endforeach

        $( document ).ready(function() {
            App.blockUI({
                boxed: true
            });
            $.ajax({
                url: "http://localhost/dress_marketplace/transaction_history",
                data : {
                    
                },
                dataType: 'html',
                success: function(html) {
                    $('#transaction_history_container').html(html);
                    App.unblockUI();
                }
            });

            $('input[name="date"]').datepicker({
                format : 'yyyy-mm-dd'
            });
        });
    </script>
@endsection
