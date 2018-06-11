@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/icheck/skins/all.css') }}
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row" style="text-align:center;">
            <h1>Checkout Successful</h1>
        </div>
        <div class="row" style="text-align:center;">
            <h3>Invoice Number : {{$data->transaction_id}}</h3>
        </div>
        <div class="row" style="text-align:center;">
            <div class="col-md-12">
                <p>
                    You have 1 x 24 hours to complete your order. <br>
                    Please transfer the amount of payment as shown below.
                </p>
            </div>
        </div>
        <div class="row" style="text-align:center; font-weight:bold;">
            <h2><b>IDR {{number_format($data->total_price)}}</b></h2>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-offset-2 col-md-10">
                @foreach($data->bank as $b)
                <div class="col-md-3" style="border:1px solid lightgrey; text-align:center; font-size:16px; margin:10px;" >
                        <img style="margin:10px auto;" width="80%" height="50px;" src="{{asset('/public/storage/').'/'.$b->logo}}">
                        <p>{{$b->account_number}}</p>
                        <p>{{$b->name_in_account}}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row" style="margin-top:50px; text-align:center;">
            <a class="btn blue">Confirm Payment</a>
        </div>
    </div>
</div>
@endsection