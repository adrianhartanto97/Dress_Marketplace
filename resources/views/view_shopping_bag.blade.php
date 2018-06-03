@extends('layout')

@section('css')
    
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row" style="text-align:center;">
                <h1>Shopping Bag</h1>
            </div>
            <div class="row" style="margin-top:50px;">
                <div class="col-md-12">
                    @foreach($result->bag as $store)
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                {{$store->store_name}}
                            </div>
                        </div>
                        <div class="portlet-body">
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
                                            <th class="hidden-xs" style="text-align:center;">
                                                </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($store->product as $p)
                                        <tr>
                                           <td>
                                                <img src="{{asset('/public/storage/').'/'.$p->product_photo}}" width="80px" style="margin: 0 auto;">
                                                <span style="margin-left:20px;"></span><b>{{$p->product_name}}</b>
                                           </td>
                                           <td style="text-align:center;vertical-align:middle;">
                                                IDR {{$p->price_unit}}
                                           </td>
                                           <td style="text-align:center;vertical-align:middle;">
                                                <b>Total : {{$p->total_qty}}</b> <br>
                                                @foreach($p->size_info as $sz)
                                                    {{$sz->size_name}} : {{$sz->product_qty}} <br>
                                                @endforeach
                                           </td>
                                           <td style="text-align:center;vertical-align:middle;">
                                                IDR {{$p->price_total}}
                                           </td>
                                           <td style="text-align:center;vertical-align:middle;">
                                                <button class="btn red">Delete from Bag</button>
                                           </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
