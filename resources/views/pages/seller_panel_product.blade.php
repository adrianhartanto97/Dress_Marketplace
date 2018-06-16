@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
@endsection

@section('content')
    <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Add Product </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Product List </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="form">
                <form class="form-horizontal" action="{{ action('Web_Controller\SellerController@add_product') }}" id="submit_form" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if (session()->has('status') && session()->get('status') == false)
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span>{{ session('message')}}</span>
                        </div>
                    @elseif(session()->has('status') && session()->get('status') == true)
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span>{{ session('message')}}</span>
                        </div>
                    @endif
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" name="store_id" value="{{$store_info->store_id}}"/>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="name"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Min Order
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="min_order"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Weight (gr)
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="weight"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Description
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-7">
                                        <textarea type="text" class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Photo <span class="required"> * </span></label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                            <div>
                                                <span class="btn red btn-outline btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="photo"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Price Range
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-12">
                                        <div class="mt-repeater">
                                            <div data-repeater-list="price_range">
                                                <div data-repeater-item class="row">
                                                    <div class="col-md-3">
                                                        <label class="control-label">Qty (Min)</label>
                                                        <input type="text" class="form-control qty_min" name="qty_min"> </div>
                                                    <!-- <div class="col-md-1">
                                                        <label class="control-label"> </label>
                                                        <p class="form-control-static">-</p>
                                                    </div> -->
                                                    <div class="col-md-4">
                                                        <label class="control-label">Qty (Max)</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control qty_max" name="qty_max">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue max_button" type="button">Max</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Price</label>
                                                        <input type="text" class="form-control" name="price"> 
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="control-label">&nbsp;</label>
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
                                                <i class="fa fa-plus"></i> Add Price Range</a>
                                            <br>
                                            <br> 
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="portlet box green-meadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span aria-hidden="true" class="icon-list"></span> Dress Attributes
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Style
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="style" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->style as $d)
                                                    <option value="{{$d->style_id}}">{{$d->style_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Size
                                            </label>
                                            <div class="col-md-7">
                                            <select class="bs-select form-control" name="size[]" multiple data-live-search="true" data-size="8" >
                                                @foreach ($dress_attributes->size as $d)
                                                    <option value="{{$d->size_id}}">{{$d->size_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Season
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="season" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->season as $d)
                                                    <option value="{{$d->season_id}}">{{$d->season_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Neck Line
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="neckline" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->neckline as $d)
                                                    <option value="{{$d->neckline_id}}">{{$d->neckline_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Sleeve Length
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="sleevelength" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->sleevelength as $d)
                                                    <option value="{{$d->sleevelength_id}}">{{$d->sleevelength_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Waiseline
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="waiseline" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->waiseline as $d)
                                                    <option value="{{$d->waiseline_id}}">{{$d->waiseline_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Material
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="material" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->material as $d)
                                                    <option value="{{$d->material_id}}">{{$d->material_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Fabric Type
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="fabrictype" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->fabrictype as $d)
                                                    <option value="{{$d->fabrictype_id}}">{{$d->fabrictype_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Decoration
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="decoration" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->decoration as $d)
                                                    <option value="{{$d->decoration_id}}">{{$d->decoration_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pattern Type
                                            </label>
                                            <div class="col-md-7">
                                                <select class="bs-select form-control" name="patterntype" data-live-search="true" data-size="8">
                                                @foreach ($dress_attributes->patterntype as $d)
                                                    <option value="{{$d->patterntype_id}}">{{$d->patterntype_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="reset" class="btn default" >Cancel</button>
                        <button type="submit" class="btn blue">
                            <i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
                tes
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/select2/js/select2.full.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{HTML::script('public/global/plugins/jquery-repeater/jquery.repeater.js')}}
    {{HTML::script('public/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    {{ HTML::script('public/pages/scripts/components-bootstrap-select.min.js') }}
    {{ HTML::script('public/js/seller_panel_product.js') }}
    <!--END PAGE LEVEL SCRIPTS-->
@endsection