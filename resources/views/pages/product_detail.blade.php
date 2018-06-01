@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    <style>
    </style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row" id="product_info">
                        <div class="col-md-4" style="text-align:center;">
                            <div class="row" style="text-align:center;">
                                <a href="{{asset('/public/storage').'/Product/photo/21_photo.jpg'}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                    <img class="img-responsive" src="{{asset('/public/storage').'/Product/photo/21_photo.jpg'}}" width="90%" style="margin: 0 auto;">
                                </a>
                            </div>
                            <div class="row" style ="margin-top:20px;">
                                <div class="my-rating" data-rating="2.9"></div>
                                (2.9)
                            </div>
                            <div class="row">
                                <h3>10 Sold</h3>
                                <button class="btn blue">Add to Wishlist</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div style ="margin-top:-20px;">
                                <h1>Product Name</h1>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        Min Order : 100 <br> <br>
                                        Price<br>
                                        <div class="table-scrollable">
                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-cart-plus"></i> Qty </th>
                                                        <th class="hidden-xs">
                                                            <i class="fa fa-money"></i> Price </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="highlight">
                                                            10 - 100
                                                        </td>
                                                        <td class="hidden-xs"> IDR 100000 </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        Weight : 200 gr <br><br>
                                        Available Size : S, M <br><br>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="portlet box green" style="margin-top:10px;">
                                        <div class="portlet-title">
                                            <div class="caption" style="font-size:14px;">
                                                Need below the min order ? <br>Check our partnership store
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd"> 
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img class="img-responsive" src="{{asset('/public/storage').'/Product/photo/21_photo.jpg'}}" alt="64x64" width="150%">
                                                            </div>
                                                            <div class="col-md-8" style="margin-left:-10px;">
                                                                <p>Store name</p>
                                                                <button type="button" class="btn blue-hoki btn-outline btn-xs">Go to Product Page</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img class="img-responsive" src="{{asset('/public/storage').'/Product/photo/21_photo.jpg'}}" alt="64x64" width="150%">
                                                            </div>
                                                            <div class="col-md-8" style="margin-left:-10px;">
                                                                <p>Store name</p>
                                                                <button type="button" class="btn blue-hoki btn-outline btn-xs">Go to Product Page</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>   
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:center; margin-top:20px;">
                                    <button type="button" class="btn red btn-lg">Add to Bag</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:50px;">
                        <div class="tabbable-custom">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"> Details </a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab"> Company Profile </a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab"> Review & Rating </a>
                                </li>
                            </ul>
                            <div id="info">
                            </div>
                            <div class="tab-content">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class = "portlet box grey-salsa">
                        <div class="portlet-title">
                            <div class="caption">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img alt="" width="100%" class="img-square" src="{{asset('/public/storage').'/Product/photo/21_photo.jpg'}}" />
                                    </div>
                                    <div class="col-md-8">
                                        Store Name
                                        <p style="font-size:14px;">
                                            City
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="portlet-body" id="store_info">
                            <div class="row">
                                <div class="col-md-6" style="text-align:center">
                                    <p>
                                        <span style="font-size:20px;">10</span>
                                        <br>
                                        Sold Products
                                    </p>
                                </div>
                                <div class="col-md-6" style="text-align:center">
                                    <p>
                                        <span style="font-size:20px;">10</span>
                                        <br>
                                        Total Transaction
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                <h4>
                                    Courier Service
                                </h4>
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

@section('script')
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
    {{HTML::script('public/star-rating-svg-master/src/jquery.star-rating-svg.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
        $( document ).ready(function() {
            $(".my-rating").starRating({
                starSize: 25,
                readOnly: true,   
            });

            var tinggi = $('#product_info').height();
            //alert(tinggi);
            $('#store_info').height(tinggi-30);
        });
    </script>
@endsection