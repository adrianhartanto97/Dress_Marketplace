@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}

      {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
     {{ HTML::style('public/global/plugins/clockface/css/clockface.css') }}

   
    {{ HTML::style('public/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}




   
    <style>
       a {
           text-decoration:none;
       }
    </style>
@endsection

@section('content')

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">

        <div class="row" style="padding:0px 10px;">
            @include('layout.user_sidebar',['login_info' => $login_info])
            <div class="col-xs-12 col-sm-9 col-md-10" >
                    
                    <div class="tab-content">
                    <div class="tabbable-custom">
                        <ul class="nav nav-tabs ">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab"> Add New Request </a>
                            </li>
                            <li>
                                <a href="#tab_2" data-toggle="tab"> Active Request </a>
                            </li>
                            <li>
                                <a href="#tab_3" data-toggle="tab"> My Request History</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="form">
                                <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@add_rfq') }}" id="submit_form" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
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
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Item's Name
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="item_name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Description
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <textarea type="text" class="form-control" name="description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Qty
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="qty"/>
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Date Expired
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                       <div class="input-group date form_datetime bs-datetime">
                                                            <input class="form-control" size="16" type="text" value="{{now()}}" name="request_expired" data-date-format="yyyy-mm HH:mm:ss" readonly>
                                                            <div class="input-group-addon">
                                                                <button class="btn date-set" type="button" style="padding: 9px;">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                               
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Budget per Unit
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="budget_unit_min" placeholder="min" />
                                                    </div>
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="budget_unit_max" placeholder="max" />
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Upload Image <span class="required"> * </span></label>
                                                    <div class="col-md-7">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                                            <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" name="photo"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <button type="reset" class="btn default" >Cancel</button>
                                        <button type="submit" class="btn blue">
                                            <i class="fa fa-check"></i> Save</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                            @foreach($active_rfq as $r)
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                {{$r->rfq_request_id}}
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="panel-group accordion" id="accordion_rfq_{{$r->rfq_request_id}}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_{{$r->rfq_request_id}}" href="#collapse_rfq_{{$r->rfq_request_id}}_1"> {{$r->item_name}} </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_rfq_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-offset-9 col-md-3" style="text-align:right;">

                                                                 <form method="POST" action="{{ action('Web_Controller\App2Controller@close_rfq_request') }}"  id="form_rfq_req">
                                                                    {{ csrf_field() }}
                                                                    <div class="form-body">
                                                                        <input type="hidden" name="rfq_request_id" value="{{$r->rfq_request_id}}">
                                                                    </div>
                                                                </form>
                                                                <button  type="submit" class="btn red" form="form_rfq_req">Close Request</button>   

                                                            </div>
                                                        </div>
                                                        <div class="form-horizontal">
                                                            <div style="margin-top:-10px">
                                                            </div>
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Description :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$r->description}}</p>
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
                                                                        <a href="{{asset('/public/storage/').'/'.$r->photo->file_path}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                                                            <img class="img-responsive" src="{{asset('/public/storage/').'/'.$r->photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-group accordion" id="accordion_rfq_offer_{{$r->rfq_request_id}}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_offer_{{$r->rfq_request_id}}" href="#collapse_rfq_offer_{{$r->rfq_request_id}}_1"> Offers </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_rfq_offer_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                                                    @if(sizeof($r->offer) > 0)
                                                    <div class="table-scrollable">
                                                        <table class="table table-striped table-bordered table-advance table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center;">
                                                                        Store </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Price </th>
                                                                    <th class="hidden-xs" style="text-align:center;"> </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($r->offer as $o)
                                                                <tr>
                                                                    <td>
                                                                        <div style="display:inline-block;">
                                                                            <img src="{{asset('/public/storage/').'/'.$o->store_photo}}" width="80px" style="margin: 0 auto;">
                                                                        </div>
                                                                        <div style="margin-left:50px;display:inline-block;">
                                                                            <div class="row"><b>{{$o->store_name}}</b></div>
                                                                            <div class="row">{{$o->city_name}}</div>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <div class="row">
                                                                            @ IDR {{number_format($o->price_unit)}}
                                                                        </div>
                                                                        <div class="row">
                                                                            Total : IDR {{number_format($o->total_price)}}
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <button class="btn green" data-toggle="modal" href="#modal_{{$o->rfq_offer_id}}">View Details</button>
                                                                         <button  type="submit" class="btn blue" form="form_accept">Accept</button> 
                                                                        <form method="POST" action="{{ action('Web_Controller\App2Controller@accept_rfq_offer') }}"  id="form_accept">
                                                                            {{ csrf_field() }}
                                                                            <div class="form-body">
                                                                                <input type="hidden" name="rfq_offer_id" value="{{$o->rfq_offer_id}}">
                                                                            </div>
                                                                        </form>
                                                                       

                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($r->offer as $o)
                                    <div class="modal fade in" id="modal_{{$o->rfq_offer_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">{{$o->store_name}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-horizontal">
                                                        <div style="margin-top:-10px">
                                                        </div>
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Description :</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">{{$o->description}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Weight per Unit :</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">{{$o->weight_unit}} gr</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Price per Unit :</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">{{$o->price_unit}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Total Price :</label>
                                                                <div class="col-md-7">
                                                                    <p class="form-control-static">{{$o->total_price}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Photo :</label>
                                                                <div class="col-md-3">
                                                                    <a href="{{asset('/public/storage/').'/'.$o->photo->file_path}}" target="_blank">
                                                                        <img class="img-responsive" src="{{asset('/public/storage/').'/'.$o->photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            @endforeach
                            </div>

                            <div class="tab-pane" id="tab_3">
                            @foreach($rfq_history as $r)
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                {{$r->rfq_request_id}}
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="panel-group accordion" id="accordion_rfq_h_{{$r->rfq_request_id}}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_h_{{$r->rfq_request_id}}" href="#collapse_rfq_h_{{$r->rfq_request_id}}_1"> {{$r->item_name}} </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_rfq_h_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                                                    <div class="panel-body">
                                                        <div class="form-horizontal">
                                                            <div style="margin-top:-10px">
                                                            </div>
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Description :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$r->description}}</p>
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
                                                                        <a href="{{asset('/public/storage/').'/'.$r->photo->file_path}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                                                            <img class="img-responsive" src="{{asset('/public/storage/').'/'.$r->photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="text-align:center;margin-bottom:20px;"><h3>Status : {{$r->rfq_status}}</h3></div>
                                        
                                        <div class="panel-group accordion" id="accordion_rfq_h_offer_{{$r->rfq_request_id}}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_h_offer_{{$r->rfq_request_id}}" href="#collapse_rfq_h_offer_{{$r->rfq_request_id}}_1"> Offers </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_rfq_h_offer_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                                                    @if(sizeof($r->offer) > 0)
                                                    <div class="table-scrollable">
                                                        <table class="table table-striped table-bordered table-advance table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center;">
                                                                        Store </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Price </th>
                                                                    <th class="hidden-xs" style="text-align:center;"> </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($r->offer as $o)
                                                                <tr>
                                                                    <td>
                                                                        <div style="display:inline-block;">
                                                                            <img src="{{asset('/public/storage/').'/'.$o->store_photo}}" width="80px" style="margin: 0 auto;">
                                                                        </div>
                                                                        <div style="margin-left:50px;display:inline-block;">
                                                                            <div class="row"><b>{{$o->store_name}}</b></div>
                                                                            <div class="row">{{$o->city_name}}</div>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <div class="row">
                                                                            @ IDR {{number_format($o->price_unit)}}
                                                                        </div>
                                                                        <div class="row">
                                                                            Total : IDR {{number_format($o->total_price)}}
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <button class="btn green" data-toggle="modal" href="#modal_h_{{$o->rfq_offer_id}}">View Details</button>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if($r->status == "1")
                                        <div class="panel-group accordion" id="accordion_rfq_h_acc_{{$r->rfq_request_id}}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion_rfq_h_acc_{{$r->rfq_request_id}}" href="#collapse_rfq_h_acc_{{$r->rfq_request_id}}_1"> Accepted Offer </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_rfq_h_acc_{{$r->rfq_request_id}}_1" class="panel-collapse in">
                                                    
                                                    <div class="table-scrollable">
                                                        <table class="table table-striped table-bordered table-advance table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center;">
                                                                        Store </th>
                                                                    <th class="hidden-xs" style="text-align:center;">
                                                                        Price </th>
                                                                    <th class="hidden-xs" style="text-align:center;"> </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $o = $r->accepted_offer;
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div style="display:inline-block;">
                                                                            <img src="{{asset('/public/storage/').'/'.$o->store_photo}}" width="80px" style="margin: 0 auto;">
                                                                        </div>
                                                                        <div style="margin-left:50px;display:inline-block;">
                                                                            <div class="row"><b>{{$o->store_name}}</b></div>
                                                                            <div class="row">{{$o->city_name}}</div>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <div class="row">
                                                                            @ IDR {{number_format($o->price_unit)}}
                                                                        </div>
                                                                        <div class="row">
                                                                            Total : IDR {{number_format($o->total_price)}}
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-align:center;vertical-align:middle;">
                                                                        <button class="btn green" data-toggle="modal" href="#modal_h_{{$o->rfq_offer_id}}">View Details</button>
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if(!empty($r->offer))
                                    @foreach ($r->offer as $o)
                                        <div class="modal fade in" id="modal_h_{{$o->rfq_offer_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">{{$o->store_name}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-horizontal">
                                                            <div style="margin-top:-10px">
                                                            </div>
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Description :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$o->description}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Weight per Unit :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$o->weight_unit}} gr</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Price per Unit :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$o->price_unit}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Total Price :</label>
                                                                    <div class="col-md-7">
                                                                        <p class="form-control-static">{{$o->total_price}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Photo :</label>
                                                                    <div class="col-md-3">
                                                                        <a href="{{asset('/public/storage/').'/'.$o->photo->file_path}}" target="_blank">
                                                                            <img class="img-responsive" src="{{asset('/public/storage/').'/'.$o->photo->file_path}}" width="90%" style="margin: 0 auto;">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach   
                            </div>
                        </div>
                    </div>
</div></div></div></div>
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
    {{HTML::script('public/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
  <!--   {{HTML::script('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}} -->
    {{HTML::script('public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}
    

        <!-- END PAGE LEVEL PLUGINS -->
<!--     {{ HTML::script('public/global/plugins/moment.min.js') }}
 -->   <!--  {{ HTML::script('public/pages/scripts/components-date-time-pickers.min.js') }}
    {{ HTML::script('public/pages/scripts/components-bootstrap-select.min.js') }} -->
    {{ HTML::script('public/js/rfq.js') }}
    <!-- {{ HTML::script('public/global/scripts/components-date-time-pickers.min.js') }} -->

    <script>
         $('.datepicker').datepicker({
            format : 'DD/MM/YYYY HH:mm',
            startDate: '-3d'
        });

        $(document).ready(function(){
            $('.panel-collapse').each(function() {
                $(this).collapse('hide');
            });
        });
    </script>
@endsection


