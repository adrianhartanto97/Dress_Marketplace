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

                <h1>New Product</h1>
                <a href="" >Go to all product page</a>

                 <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="row">
                            @for($i=0;$i<=3;$i++)
                            <a href="" target="_blank" style="text-decoration:none;">
                            <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="thumbnail">
                                    <img src="../dress_marketplace/public/storage/carousel/carousel2.jpg" alt="" style="width: 100%; height: 35%;">
                                    <div class="caption" style="text-align:center;">
                                        <h4>a</h4>
                                        <h3>sdsd</h3>
                                        <p><a href="$" target="_blank" class="my-rating satu" data-rating="3"></a></p>
                                    </div>
                                </div>
                            </div>
                            </a>
                         @endfor
                        </div>
                    </div>
                </div>

                <h1>Best Seller</h1>
                <a href="" >Go to all product page</a>

                 <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="row">
                            @for($i=0;$i<=3;$i++)
                            <a href="" target="_blank" style="text-decoration:none;">
                            <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="thumbnail">
                                    <img src="../dress_marketplace/public/storage/carousel/carousel3.jpg" alt="" style="width: 100%; height: 35%;">
                                    <div class="caption" style="text-align:center;">
                                        <h4>a</h4>
                                        <h3>sdsd</h3>
                                        <p><a href="$" target="_blank" class="my-rating satu" data-rating="3"></a></p>
                                    </div>
                                </div>
                            </div>
                            </a>
                         @endfor
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
@endsection
