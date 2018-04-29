@extends('layout')

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
            <div class="row" style="padding:0px 10px;">
            @if($login_info->login_status == true)
            <div class="col-xs-12 col-sm-3 col-md-2">
                <div class="row">
                    <div class = "portlet box blue-hoki">
                        <div class="portlet-title">
                            <div class="caption">
                                <img alt="" width="30px" class="img-circle" src="{{asset('/public/storage').'/'.$login_info->user_info->avatar}}" />
                                <span class="username username-hide-on-mobile"> <b>{{ $login_info->user_info->full_name }}</b> </span>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>
                                        <i class="fa fa-money"></i>
                                        IDR 0
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p><b>My Store</b></p>
                                    <p style="margin-top:-15px;">
                                        <i class="fa fa-building"></i>
                                        aaa
                                    </p>
                                    <button style="margin-top:-10px;" type="button" class="btn blue btn-sm btn-block">Open Seller Panel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="@if($login_info->login_status == true)col-xs-12 col-sm-9 col-md-10 @else col-xs-12 col-sm-12 col-md-12 @endif">
                <div id="carousel-example-generic-v1" class="carousel slide widget-carousel" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators carousel-indicators-red">
                        <li data-target="#carousel-example-generic-v1" data-slide-to="0" class="circle active"></li>
                        <li data-target="#carousel-example-generic-v1" data-slide-to="1" class="circle"></li>
                        <li data-target="#carousel-example-generic-v1" data-slide-to="2" class="circle"></li>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="widget-gradient" style="background-image: url(../dress_marketplace/public/storage/carousel/carousel1.jpg); background-size: 100% 100%;">
                                <div class="widget-gradient-body">
                                    <h3 class="widget-gradient-title">Dress Marketplace</h3>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="widget-gradient" style="background-image: url(../dress_marketplace/public/storage/carousel/carousel2.jpg); background-size: 100% 100%;">
                                <div class="widget-gradient-body">
                                    <h3 class="widget-gradient-title">Dress Marketplace</h3>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="widget-gradient" style="background-image: url(../dress_marketplace/public/storage/carousel/carousel3.jpg); background-size: 100% 100%;">
                                <div class="widget-gradient-body">
                                    <h3 class="widget-gradient-title">Dress Marketplace</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
@endsection
