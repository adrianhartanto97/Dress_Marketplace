@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
@endsection

@section('content')
    <form class="form-horizontal" action="{{ action('Web_Controller\SellerController@test') }}" id="submit_form" method="POST">
    {{ csrf_field() }}
        <div class="form-body">
            <h3 class="block">Provide your Store Information</h3>
            <div class = "row">
                <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Store Name
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="store_name" value="{{$store_info->store_name}}" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Business Type
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <select class="form-control" name="business_type" value="{{$store_info->business_type}}" id="business_type">
                                <option value="Manufacturer / Factory">Manufacturer / Factory</option>
                                <option value="Trading Company">Trading Company</option>
                                <option value="Distributor / Wholesaler">Distributor / Wholesaler</option>
                                <option value="Retailer">Retailer</option>
                                <option value="Buying Office">Buying Office</option>
                                <option value="Online Shop / Store">Online Shop / Store</option>
                                <option value="Individual">Individual</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Established Year
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="established_year" value="{{$store_info->established_year}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Province
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="province" id="province">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">City
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="city" id="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span aria-hidden="true" class="icon-user"></span> Contact Person
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="contact_person_name" value="{{$store_info->contact_person_name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Job Title
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="contact_person_job_title" value="{{$store_info->contact_person_job_title}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone Number
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="contact_person_phone_number" value="{{$store_info->contact_person_phone_number}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Store Description
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <textarea type="text" class="form-control" name="description">{{$store_info->description}}</textarea>
                        </div>
                    </div>
                </div>

                <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Photo</label>
                        <div class="col-md-3">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="hidden" value="" name="..."><input type="file" name="photo"> </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Banner</label>
                        <div class="col-md-3">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="hidden" value="" name="..."><input type="file" name="banner"> </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        document.getElementById('business_type').value="{{$store_info->business_type}}";
        document.getElementById('province').value="{{$store_info->province}}";
        document.getElementById('city').value="{{$store_info->city}}";
    </script>
@endsection