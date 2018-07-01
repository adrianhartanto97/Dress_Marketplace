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
                                        <form action="#" class="form-horizontal">
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
                                                                                        <button class="btn blue">Request Partnership</button>
                                                                                    @endif
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
                                            </div>
                                        </form>
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
    <script>
        
    </script>
@endsection