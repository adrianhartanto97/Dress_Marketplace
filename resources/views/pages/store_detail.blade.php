@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
     {{ HTML::style('public/global/plugins/ion.rangeslider/css/ion.rangeSlider.css')}}
    {{ HTML::style('public/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css')}}
    {{ HTML::style('public/global/plugins/nouislider/nouislider.min.css')}}
    {{ HTML::style('public/global/plugins/nouislider/nouislider.pips.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}

    <style>
    </style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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

                    
                   
                    <div class="row" style="margin-top:50px;">
                            <div class="col-md-8  porlet box grey-salsa" style="border:2px solid black;height: 32%;background-image:url('asset/storage/Product/photo/1_photo.jpg')">
                             <div class="row" >
                                <div class="col-md-4">
                                    <img alt="" width="100%" class="img-square" src="{{asset('/public/storage').'/'.$product_detail->store_info->photo}}" />
                                </div>
                                <div class="col-md-4">
                                    <h3>{{$product_detail->store_info->name}}</h3>
                                    <h4>{{$product_detail->store_info->city_name}}</h4>
                                    

                                    @if($product_detail->wishlist_status=="true")
                                        <form method="POST" action="{{ action('Web_Controller\App2Controller@delete_from_wishlist') }}"  id="form3">
                                            {{ csrf_field() }}
                                            <div class="form-body">
                                                <input type="hidden" name="product_id" value="{{$product_detail->product_info->product_id}}">
                                            </div>
                                        </form>
                                        <button  type="submit" class="btn blue" form="form3" width="200px"  @if($login_info->login_status == false) disabled @endif>Remove from Favorite</button>                                
                                    @else
                                        <form method="POST" action="{{ action('Web_Controller\App2Controller@add_to_wishlist') }}"  id="form2">
                                            {{ csrf_field() }}
                                            <div class="form-body">
                                                <input type="hidden" name="product_id" value="{{$product_detail->product_info->product_id}}">
                                            </div>
                                        </form>
                                        <button  type="submit" class="btn blue" form="form2"  @if($login_info->login_status == false) disabled @endif>Add to Favorite </button>
                                     @endif
                                </div>
                                <div class="col-md-4">
                                    
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4" style="border:2px solid black;height:32%;">
                                <div class="col-md-12" style="margin-top: 50px">
                                    <div class="row">
                                        <div class="col-md-6" style="text-align:center;border-right: 2px solid black;">
                                            <p>
                                                <span style="font-size:20px;">{{$product_detail->store_info->sold_product}}</span>
                                                <br>
                                                Sold Products
                                            </p>
                                        </div>
                                        <div class="col-md-6" style="text-align:center">
                                            <p>
                                                <span style="font-size:20px;">{{$product_detail->store_info->transaction}}</span>
                                                <br>
                                                Total Transaction
                                            </p>
                                        </div>
                                    </div>
                                   <div class="row" style ="margin-top:20px;">
                                        <div class="col-md-12" style="text-align:center">
                                            <div class="my-rating" data-rating="{{$product_detail->product_info->rating}}"></div>
                                        </div> <br>
                                    </div>  
                                </div>
                            </div>
                        
                    </div>

                    <div class="row" style="margin-top:50px;">
                        <div class="tabbable-custom">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"> Products</a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab"> Company Profile </a>
                                </li>
                                
                            </ul>
                            <div id="info">
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-3">
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
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green button-submit"> Apply Filter
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="portlet light bordered">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <p id="dynamic_pager_content2" class="well">Showing 100 products for "Pretty Dress"</p>
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
                                                        @for($i=0;$i<=10;$i++)
                                                        <a href="" target="_blank" style="text-decoration:none;">
                                                        <div class="col-xs-6 col-sm-4 col-md-3">
                                                            <div class="thumbnail">
                                                                <img src="../dress_marketplace/public/storage/carousel/carousel2.jpg" alt="" style="width: 100%; height: 20%;">
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

                                                    <p id="dynamic_pager_demo2" style="text-align: center;"> </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight">Store Name</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Established Year</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->established_year}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Province</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->province_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">City</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->city_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Business Type</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->business_type}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Description</td>
                                                            <td class="hidden-xs">
                                                                
                                                                    {{$product_detail->store_info->description}}
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Contact Person Name</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->contact_person_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Contact Person Job Title</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->contact_person_job_title}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Contact Person Phone Number</td>
                                                            <td class="hidden-xs">{{$product_detail->store_info->contact_person_phone_number}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
    {{HTML::script('public/global/plugins/fuelux/js/spinner.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}
    <!--END PAGE LEVEL PLUGINS-->
        {{HTML::script('public/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js')}}
        {{HTML::script('public/pages/scripts/components-ion-sliders.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/nouislider.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/wNumb.min.js')}}
        {{HTML::script('public/global/plugins/nouislider/nouislider.min.js')}}
         {{HTML::script('public/global/plugins/jquery.pulsate.min.js')}}
        {{HTML::script('public/global/plugins/jquery-bootpag/jquery.bootpag.min.js')}}
        {{HTML::script('public/global/plugins/holder.js')}}
        {{HTML::script('public/pages/scripts/ui-general.min.js')}}

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->
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