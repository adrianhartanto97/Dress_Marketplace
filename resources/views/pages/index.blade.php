@extends('layout')

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
            <div class="row" style="padding:0px 10px;">
            @include('layout.user_sidebar',['login_info' => $login_info])
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
