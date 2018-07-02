@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}

    <style>
    </style>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
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

                    
                    <div class="row" id="product_info">
                        <div class="col-md-4" style="text-align:center;">
                            <div class="row" style="text-align:center;">
                                <a href="{{asset('/public/storage').'/'.$product_detail->product_info->photo}}" class="fancybox-button" data-rel="fancybox-button" style="margin: 0 auto;">
                                    <img class="img-responsive" src="{{asset('/public/storage/').'/'.$product_detail->product_info->photo}}" width="90%" style="margin: 0 auto;">
                                </a>
                            </div>
                            <div class="row" style ="margin-top:20px;">
                                <div class="my-rating" data-rating="{{$product_detail->product_info->rating}}"></div>
                                ({{$product_detail->product_info->rating}})
                            </div>
                            <div class="row">
                                <h3>{{$product_detail->product_info->sold}} Sold</h3>
                                @if($product_detail->wishlist_status=="true")
                                    <form method="POST" action="{{ action('Web_Controller\App2Controller@delete_from_wishlist') }}"  id="form3">
                                        {{ csrf_field() }}
                                        <div class="form-body">
                                            <input type="hidden" name="product_id" value="{{$product_detail->product_info->product_id}}">
                                        </div>
                                    </form>
                                    <button  type="submit" class="btn blue" form="form3" width="200px"  @if($login_info->login_status == false) disabled @endif>Remove from Wishlist</button>                                
                                @else
                                    <form method="POST" action="{{ action('Web_Controller\App2Controller@add_to_wishlist') }}"  id="form2">
                                        {{ csrf_field() }}
                                        <div class="form-body">
                                            <input type="hidden" name="product_id" value="{{$product_detail->product_info->product_id}}">
                                        </div>
                                    </form>
                                    <button  type="submit" class="btn blue" form="form2"  @if($login_info->login_status == false) disabled @endif>Add to Wishlist</button>
                                 @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div style ="margin-top:-20px;">
                                <h1>{{$product_detail->product_info->product_name}}</h1>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        Min Order : {{$product_detail->product_info->min_order}} <br> <br>
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
                                                    @foreach ($product_detail->product_info->price as $pp)
                                                    <tr>
                                                        <td class="highlight">
                                                            @if ($pp->qty_max != "max")
                                                                {{$pp->qty_min}} - {{$pp->qty_max}}
                                                            @else
                                                                >= {{$pp->qty_min}}
                                                            @endif
                                                        </td>
                                                        <td class="hidden-xs"> IDR {{$pp->price}} </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        Weight : {{$product_detail->product_info->weight}} gr <br><br>
                                        Available Size : 
                                        @php
                                        $sz = $product_detail->product_info->size;
                                        @endphp
                                        @for ($i = 0; $i < count($sz) ; $i++)
                                            {{$sz[$i]->size_name}}
                                            @if ($i != count($sz)-1)
                                            , 
                                            @endif
                                        @endfor
                                        <br><br>
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
                            

                            <!--begin modal -->
                            <div class="modal fade bs-modal-sm" id="add_to_bag" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Add to Bag</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="row" style="text-align:center;">
                                                            <img class="img-responsive" src="{{asset('/public/storage/').'/'.$product_detail->product_info->photo}}" width="90%" style="margin: 0 auto;">
                                                        </div>
                                                    <div class="row" style ="margin-top:20px; text-align:center;">
                                                        <h3>{{$product_detail->product_info->product_name}}</h3>
                                                    </div>
                                                </div>

                                                <div class="col-md-7" style="text-align : center;">
                                                    <form method="post" action="{{ action('Web_Controller\AppController@add_to_bag') }}" class="form-horizontal" id="form1">
                                                        {{ csrf_field() }}
                                                        <div class="form-body">
                                                            <input type="hidden" name="product_id" value="{{$product_detail->product_info->product_id}}">
                                                            @foreach ($product_detail->product_info->size as $s)
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">
                                                                    {{$s->size_name}}
                                                                </label>
                                                                <div class="col-md-7">
                                                                    <input id="touchspin_{{$s->size_id}}" type="text" value ="0" name="size[{{$s->size_id}}]" class="dress_size" onchange="hitung()">
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </form>

                                                    <h4 style="margin-top:50px;"><b id="total_harga"></b></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                            <button type="submit" id="btn_bag" class="btn red" form="form1" disabled>Add to Bag</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!--end modal -->
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
                                        <div class="col-md-8">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-bordered table-advance table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight">Style</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->style_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Season</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->season_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Neckline</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->neckline_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Sleeve Length</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->sleevelength_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Waiseline</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->waiseline_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Material</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->material_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Fabric Type</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->fabrictype_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Decoration</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->decoration_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="highlight">Pattern Type</td>
                                                            <td class="hidden-xs">{{$product_detail->product_info->patterntype_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
                <div class="col-md-3">
                    <div class = "portlet box grey-salsa">
                        <div class="portlet-title">
                            <div class="caption">
                                <a href="{{url('/store_detail')}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img alt="" width="100%" class="img-square" src="{{asset('/public/storage').'/'.$product_detail->store_info->photo}}" />
                                    </div>
                                    <div class="col-md-8">
                                        
                                            {{$product_detail->store_info->name}}
                                            <p style="font-size:14px;">
                                            {{$product_detail->store_info->city_name}}
                                            </p>
                                        
                                    </div>
                                </div>
                                </a>

                            </div>
                        </div>

                        <div class="portlet-body" id="store_info">
                            <div class="row">
                                <div class="col-md-6" style="text-align:center">
                                    <p>
                                        <span style="font-size:20px;">{{$product_detail->store_info->sold}}</span>
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

                            <div class="row">
                                <div class="col-md-12">
                                <h4>
                                    Courier Service
                                </h4>
                                </div>
                            </div>

                            @foreach ($product_detail->store_info->courier_service as $c)
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-5">
                                    <img class="img-responsive" src="{{asset('/public/storage/').'/'.$c->logo}}" width="100%" style="margin: 0 auto;">
                                </div>
                                <div class="col-md-7">
                                    {{$c->courier_name}}
                                </div>
                            </div>
                            @endforeach
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

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    <!--END PAGE LEVEL SCRIPTS-->



   
@endsection