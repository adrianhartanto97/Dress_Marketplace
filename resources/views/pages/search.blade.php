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
                                    <input type="number" class="form-control" min="0" value="0">
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
                                    <select class="form-control" name="province">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                 <div class="col-md-12">
                                    <label class="control-label">City</label>  
                                 </div>
                                
                                <div class="col-md-12">
                                    <select class="form-control" name="city">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Shipping</label>
                                </div>
                                
                                <div class="col-md-12">
                                    <select class="form-control" name="shipping" >
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
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>
                     <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green button-submit"> Apply Filter
                                </button>
                            </div>
                        </div>
                    </div>
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
                                    <p id="dynamic_pager_content2" class="well">Showing 100 products for </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                 <div class="col-md-7">
                                    
                                </div>
                                 <div class="col-md-4">
                                    <div class="col-md-3">
                                         Sort By
                                    </div>
                                    <div class="col-md-9">
                                         <select class="form-control" name="sort_by">
                                            <option value="recommended">recommended</option>
                                            <option value="Newest">Newest</option>
                                            <option value="Oldest">Oldest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="portlet-body">


                        <div class="row">
                             @foreach ($result->product_info as $w)
                            <a href="" target="_blank" style="text-decoration:none;">
                            <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="thumbnail">
                                    <img src="../dress_marketplace/public/storage/carousel/carousel2.jpg" alt="" style="width: 100%; height: 35%;">
                                    <div class="caption" style="text-align:center;">
                                        <h4>{{$w->product_name}}</h4>
                                        <h3>sdsd</h3>
                                        <p><a href="$" target="_blank" class="my-rating satu" data-rating="3"></a></p>
                                    </div>
                                </div>
                            </div>
                            </a>
                             @endforeach
                        </div>

                        <p id="dynamic_pager_demo2" style="text-align: center;"> </p>

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
        {{HTML::script('public/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js')}}
        {{HTML::script('public/pages/scripts/components-ion-sliders.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/nouislider.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/wNumb.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/nouislider.min.js')}}
        {{HTML::script('public/global/plugins/jquery.pulsate.min.js')}}
        {{HTML::script('public/global/plugins/jquery-bootpag/jquery.bootpag.min.js')}}
        {{HTML::script('public/global/plugins/holder.js')}}
        {{HTML::script('public/pages/scripts/ui-general.min.js')}}
        {{HTML::script('public/js/search.js')}}
  
      
       
    <script>
    
        $( document ).ready(function() {
            $(".my-rating").starRating({
                starSize: 25,
                readOnly: true,   
            });
        });

        $("#range_25").ionRangeSlider({
            type: "double",
            min: 1,
            max: 5,
            from: 1,
            to: 5,
            hide_min_max: true,
            hide_from_to: false,
            grid: false
        });

         $("#range_26").ionRangeSlider({
            type: "double",
            min: 10000,
            max: 50000000,
            from: 10000,
            to: 50000000,
            hide_min_max: true,
            hide_from_to: false,
            grid: false
        });

    </script>
@endsection