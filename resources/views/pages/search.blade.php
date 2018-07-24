@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}
 {{ HTML::style('public/global/plugins/ion.rangeslider/css/ion.rangeSlider.css')}}
    {{ HTML::style('public/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css')}}
    {{ HTML::style('public/global/plugins/nouislider/nouislider.min.css')}}
    {{ HTML::style('public/global/plugins/nouislider/nouislider.pips.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}


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
            <div class="col-xs-12 col-sm-3 col-md-2">
                <div class="row">
                    
                    <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@filter') }}"" id="filter" method="post"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption">
                                    Search
                                </div>
                            </div>
                            
                            <div class="portlet-body">
                                <div class="form-group">
                                     <div class="col-md-7">
                                        <label class="control-label">Min Order</label>
                                     </div>
                                     <div class="col-md-5">
                                        <input type="number" name="min_order" id="min_order" class="form-control" min="0" value="0">
                                     </div>
                                </div>
                                 <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Price</label>
                                    </div>
                                    <div class="col-md-12">
                                        <input id="range_26" type="range"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Province</label>

                                    </div>
                                    <div class="col-md-12">
                                        <select class="form-control" name="province" id="province_select">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <div class="col-md-12">
                                        <label class="control-label">City</label>  
                                     </div>
                                    
                                    <div class="col-md-12">
                                        <select class="form-control" name="city" id="city_select">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Shipping</label>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <select class="form-control" name="shipping" id="shipping_select">
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">Rating</label>
                                    
                                    <div class="col-md-12">
                                        <input id="range_25" type="range"  />
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label">

                                    </label>

                                    <div class="col-md-12">
                                        <input type="text" id="price_min" name="price_min" value="1" hidden="">
                                         <input type="text" id="price_max"  name="price_max" value="50000000" hidden="">
                                        <input type="text" id="rating_min" name="rating_min" hidden="" value="0">
                                        <input type="text" id="rating_max" name="rating_max" value="5" hidden="" >
                                                                               
                                        <input type="text" id="province" name="province" value="" hidden="">
                                        <input type="text" id="city" name="city" value="" hidden="">
                                        <input type="text" id="courier_id" name=
                                        "courier_id" value="1" hidden="">



                                    </div>
                                </div>
                                
                                
                            </div>

                        </div>
                         <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green button-submit" form="filter" onclick="reload()"> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

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
                   
                    
                </div> 
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if($has_search == "true")
                                        @if($search_result->count == $search_result->count_all)
                                        <p id="dynamic_pager_content2" class="well">Showing All products</p>

                                        @elseif ($search_result->count!=0)
                                        <p id="dynamic_pager_content2" class="well">Showing {{$search_result->count}} products for {{$search_result->query}}</p>


                                        @else 
                                        <p id="dynamic_pager_content2" class="well">No Result</p>
                                        @endif
                                    @else
                                        @if($filter_result->count == $filter_result->count_all)
                                        <p id="dynamic_pager_content2" class="well">Showing All products</p>

                                        @elseif ($filter_result->count!=0)
                                        <p id="dynamic_pager_content2" class="well">Showing {{$filter_result->count}} of {{$filter_result->count_all}}</p>

                                        @else 
                                        <p id="dynamic_pager_content2" class="well">No Result</p>
                                        @endif
                                    @endif

                                </div>
                            </div>

                            @if($has_search == "true")
                                @if ($search_result->count!=0)
                                <div class="col-md-12">
                                     <div class="col-md-7">
                                        
                                    </div>
                                     <div class="col-md-4">
                                        <div class="col-md-3">
                                             Sort By
                                        </div>
                                        <div class="col-md-9">
                                             <select class="form-control" name="sort_by">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 @endif
                            @else
                                 @if ($filter_result->count!=0)
                                <div class="col-md-12">
                                     <div class="col-md-7">
                                        
                                    </div>
                                     <div class="col-md-4">
                                        <div class="col-md-3">
                                             Sort By
                                        </div>
                                        <div class="col-md-9">
                                             <select class="form-control" name="sort_by">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 @endif
                            @endif

                        </div>
                    </div>
                    <div class="portlet-body">

                        @if($has_search == "true")
                            <div class="row tampung" name="list">
                                 @foreach ($search as $w)
                               <a href="{{url('/product_detail')}}/{{$w->product_id}}"  style="text-decoration:none;">
                                <div class="col-lg-3 col-xs-6 col-sm-4 col-md-3 center">
                                    <div class="thumbnail">
                                        <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 170px;">
                                            <div style="height: 60px;">
                                                 <h4 class="black">
                                                    @if(strlen($w->product_name) > 60 )
                                                    {{substr($w->product_name,0,60)."..."}}
                                                    @else
                                                    {{$w->product_name}}
                                                    @endif
                                                </h4>
                                            </div>
                                           
                                        <b>{{$w->store_name}}</b>
                                        <h3>IDR {{$w->max_price}}</h3>
                                         <p class="my-rating" data-rating="{{$w->average_rating}}"></p>
                                    </div>
                                </div>
                             </a>
                                 @endforeach
                            </div>
                            <div class="row" style="text-align:center;">
                                {!! $search->render() !!}
                            </div>
                        @elseif($has_search == "false")
                             <div class="row tampung" name="list">
                                 @foreach($filter_result as $w)
                                <a href="{{url('/product_detail')}}/{{$w->product_id}}"  style="text-decoration:none;">
                                <div class=" col-xs-6 col-sm-4 col-md-3 center">
                                    <div class="thumbnail">
                                        <img src="{{asset('/public/storage/').'/'.$w->photo}}" alt="" style="width: 100%; height: 170px;">
                                            <div style="height: 60px;">
                                                 <h4 class="black">
                                                    @if(strlen($w->product_name) > 60 )
                                                    {{substr($w->product_name,0,60)."..."}}
                                                    @else
                                                    {{$w->product_name}}
                                                    @endif
                                                </h4>
                                            </div>
                                           
                                        <b>{{$w->store_name}}</b>
                                        <h3>IDR {{$w->max_price}}</h3>
                                         <p class="my-rating" data-rating="{{$w->average_rating}}"></p>
                                    </div>
                                </div>
                             </a>
                                 @endforeach
                            </div>
                         @endif

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

@section('script')

    {{HTML::script('public/star-rating-svg-master/src/jquery.star-rating-svg.js')}}
        {{HTML::script('public/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js')}}
        {{HTML::script('public/pages/scripts/components-ion-sliders.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/nouislider.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/wNumb.min.js')}}
        {{HTML::script('public/global/plugins/jquery.pulsate.min.js')}}
        {{HTML::script('public/global/plugins/jquery-bootpag/jquery.bootpag.min.js')}}
        {{HTML::script('public/global/plugins/holder.js')}}
        {{HTML::script('public/pages/scripts/ui-general.min.js')}}
        {{HTML::script('public/js/search.js')}}
@endsection
