@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}
   
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
                       
                         <!-- @foreach ($result->result as $w)
                        <div class="col-xs-12 col-sm-6 col-md-4 baner-top ban-mar animated fadeIn " data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn; height:200px;width:250px;" href="product_detail/{{$w->product_id}}" target="_blank">
                            <a href="product_detail/{{$w->product_id}}" target="_blank" class="b-link-stripe b-animate-go  swipebox">
                                <div class="gal-spin-effect vertical kotak">

                                    <img class="img-responsive" src="{{asset('/public/storage/').'/'.$w->photo}}" alt=" " style="width:100%; height:100%;margin: 0 auto;"/>
                                    <div class="gal-text-box">
                                        <div class="info-gal-con">
                                            <h5> {{$w->store_name}}</h5>
                                            <span class="separator"></span>
                                            <p>{{$w->description}}</p>
                                            <span class="separator"></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="satu"><b><a href="product_detail/{{$w->product_id}}" target="_blank">{{$w->product_name}}</a></b></div>
                            <div class="satu"><b><a href="product_detail/{{$w->product_id}}" target="_blank">{{$w->store_name}}</a></b></div>
                            <div>  <a href="product_detail/{{$w->product_id}}" target="_blank" class="my-rating satu" data-rating="{{$w->rating}}"></a></div>

                        </div>
                        @endforeach   -->
                        <div class="portlet light bordered">
                            <div class="row" style="text-align:center;">
                                <h1>My Wishlist</h1>
                            </div>
                        </div>
                        <div class="portlet light bordered">

                            <div class="portlet-body">

                                <div class="row">
                                    @foreach ($result->result as $w)
                                    <a href="product_detail/{{$w->product_id}}" target="_blank" style="text-decoration:none;">
                                    <div class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="thumbnail">
                                            <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 300px;">
                                            <div class="caption" style="text-align:center;">
                                                <h4>{{$w->product_name}}</h4>
                                                <h3>{{$w->store_name}}</h3>
                                                <p><a href="product_detail/{{$w->product_id}}" target="_blank" class="my-rating satu" data-rating="{{$w->rating}}"></a></p>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                    @endforeach 

                                
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
        });

    </script>
@endsection