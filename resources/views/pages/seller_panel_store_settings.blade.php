@extends('pages.seller_panel_layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
@endsection

@section('content')

 <div class="tabbable-custom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_1" data-toggle="tab"> Store Information </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab"> Supporting Documents</a>
            </li>
             <li>
                <a href="#tab_3" data-toggle="tab"> Courier Service</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
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
                       
                <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@update_store_information') }}" id="save_change" method="POST" enctype="multipart/form-data">


                {{ csrf_field() }}
                 <input type="text" name="store_id" value="{{$store_info->store_id}}" hidden="true" />
                    <div class="form-body">
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
                                        <label class="control-label col-md-3">Photo <span class="required"> * </span></label>
                                        <div class="col-md-7">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> 
                                                    <img src="{{asset('/public/storage/').'/'.$store_info->photo}}">
                                                </div>
                                                <div>
                                                    <span class="btn red btn-outline btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="hidden" value="{{$store_info->photo}}" name="..."><input type="file" name="photo"> </span>
                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Banner <span class="required"> * </span></label>
                                        <div class="col-md-7">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> 
                                                    <img src="{{asset('/public/storage/').'/'.$store_info->banner}}">
                                                </div>
                                                <div>
                                                    <span class="btn red btn-outline btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="hidden" value="{{$store_info->banner}}" name="..."><input type="file" name="banner"> </span>
                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                        </div>
                    </div>
                </form>
                <div class="form-actions" style="text-align: center;">
                    <button type="submit" class="btn blue" form="save_change">Save Changes</button>
                     
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
                 <form class="form-horizontal" action="" id="submit_form" method="POST">
                {{ csrf_field() }}
                    <div class="form-body">
                        <div class = "row">
                             <div class = "col-md-3">
                             </div>
                            <div class = "col-md-6">
                                    
                                    <div class="portlet-body">
                                        <div class="form-group">
                                         
                                            <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">KTP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : not submitted yet</span>                    
                                                </div>

                                            </div>

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
                                                            <input type="hidden" value="" name="..."><input type="file" name="ktp"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">SIUP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : not submitted yet</span>                    
                                                </div>

                                            </div>

                                           
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
                                                            <input type="hidden" value="" name="..."><input type="file" name="siup"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">NPWP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : not submitted yet</span>                    
                                                </div>

                                            </div>

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
                                                            <input type="hidden" value="" name="..."><input type="file" name="npwp"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                <div class="col-md-6" >
                                                    <div class="col-md-12">
                                                        <div class="control-label" style="text-align: left;">SKDP</div>
                                                    </div>
                                                    <div class="col-md-12" style="text-align: left;">
                                                        <span>Status : not submitted yet</span>                    
                                                    </div>

                                                </div>                                            <div class="col-md-3">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="input-group input-large">
                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn default btn-file">
                                                            <span class="fileinput-new"> Select file </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="hidden" value="" name="..."><input type="file" name="skdp"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                <div class="col-md-6" >
                                                    <div class="col-md-12">
                                                        <div class="control-label" style="text-align: left;">TDP</div>
                                                    </div>
                                                    <div class="col-md-12" style="text-align: left;">
                                                        <span>Status : not submitted yet</span>                    
                                                    </div>

                                                </div>                                            <div class="col-md-3">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="input-group input-large">
                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                            <span class="fileinput-filename"></span>
                                                        </div>
                                                        <span class="input-group-addon btn default btn-file">
                                                            <span class="fileinput-new"> Select file </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="hidden" value="" name="..."><input type="file" name="tdp"> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class = "col-md-3">
                             </div>
                        </div>
                    </div>
                </form>
           
            </div>
            <div class="tab-pane" id="tab_3">
                    <form class="form-horizontal" action="" id="submit_form" method="POST">
                {{ csrf_field() }}
                    <div class="form-body">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class="form-group" style="text-align: center;">
                                    <div class="col-md-3">
                                    Courier Service                                
                                    </div>
                                    <div class="col-md-3">
                                        <select name="gender" class="form-control" value="" id="History">
                                            <option value="JNE">JNE</option>
                                            <option value="TIKI">TIKI</option>
                                          
                                        </select>                                    
                                    </div>
                                </div>
                               
                                <div class="form-group" style="text-align: center;">
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                         <button type="button" class="btn blue" data-toggle="modal" href="" >Add Courier</button><br><br>

                                    </div>
                                    
                                   
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th>Courier Code</th>
                                                    <th>Courier Name</th>
                                                    <th>Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> JNE </td>
                                                    <td> Jalur Nugroho Ekokurir </td>
                                                    <td> <a>Delete</a> </td>
                                                 

                                                </tr>
                                              
                                               
                                            </tbody>
                                        </table>

                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                    </div>

                                    
                                </div>


                                

                               
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    
@endsection

@section('script')
{{HTML::script('public/global/plugins/select2/js/select2.full.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{HTML::script('public/global/plugins/icheck/icheck.min.js')}}
     {{ HTML::script('public/js/store_setting.js') }}
    <script>
    
        document.getElementById('business_type').value="{{$store_info->business_type}}";
        document.getElementById('province').value="{{$store_info->province}}";
        document.getElementById('city').value="{{$store_info->city}}";

    

    </script>
@endsection