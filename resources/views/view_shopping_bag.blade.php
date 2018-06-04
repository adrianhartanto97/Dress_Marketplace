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
                                                <form method="post" action="{{ action('Web_Controller\AppController@delete_product_from_bag') }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="product_id" value="{{$p->product_id}}">
                                                    <button class="btn red" type="submit">Delete from Bag</button>
                                                </form>
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
