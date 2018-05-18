@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/icheck/skins/all.css') }}
@endsection

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <div class="portlet light bordered" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-red"></i>
                    <span class="caption-subject font-red bold uppercase"> Open Store -
                        <span class="step-title"> Step 1 of 4 </span>
                    </span>
                </div>
            <div id="field" data-field-id="{{$jwt}}"></div>    
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" action="{{ action('Web_Controller\AppController@register_store') }}" id="submit_form" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Choose Store Name </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Store Information </span>
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="#tab3" data-toggle="tab" class="step active">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Bank Account </span>
                                    </a>
                                </li> -->
                                <li>
                                    <a href="#tab3" data-toggle="tab" class="step">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Courier Service </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab4" data-toggle="tab" class="step">
                                        <span class="number"> 4 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Confirm </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success"> </div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none" id="alert_error">
                                    <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button> Your form validation is successful! </div>
                                <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Choose Store Name</h3>
                                    <div class="note note-info">
                                        <p>Registered store name can not be changed anymore. So make sure the entered store name is correct. </p>
                                     </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Store Name
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="store_name" />
                                            <b><span class="help-block text-info" id="store_availability"></span></b>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn green-meadow" id="check_store_name">Check Store Name</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <h3 class="block">Provide your store information</h3>
                                    <div class = "row">
                                        <div class = "col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Store Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="store_name_2" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Business Type
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="business_type">
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
                                                    <input type="text" class="form-control" name="established_year">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Province
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="province">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">City
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="city">
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
                                                                <input type="text" class="form-control" name="contact_person_name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Job Title
                                                            </label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="contact_person_job_title">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Phone Number
                                                            </label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="contact_person_phone_number">
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
                                                    <textarea type="text" class="form-control" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class = "col-md-6">
                                            <div class="portlet box green-meadow">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <span aria-hidden="true" class="icon-docs"></span> Supporting Documents
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">KTP</label>
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
                                                        <label class="control-label col-md-3">SIUP</label>
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
                                                        <label class="control-label col-md-3">NPWP</label>
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
                                                        <label class="control-label col-md-3">SKDP</label>
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
                                                                        <input type="hidden" value="" name="..."><input type="file" name="skdp"> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">TDP</label>
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
                                                                        <input type="hidden" value="" name="..."><input type="file" name="tdp"> </span>
                                                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                <!-- <div class="tab-pane" id="tab3">
                                    <h3 class="block">Provide your store bank account</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Bank Name
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Bank Account Number
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="bank_account_number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Branch
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="branch">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Name in Bank Account
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="name_in_bank_account">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="tab-pane" id="tab3">
                                    <h3 class="block">Choose Courier Service</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Courier Service
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="icheck-list" id="courier_input">
                                                    <!-- <label>
                                                        <input type="checkbox" class="icheck" name="courier"> Checkbox 1 </label>
                                                    <label>
                                                        <input type="checkbox" class="icheck" name="courier"> Checkbox 2 </label>
                                                    <label>
                                                        <input type="checkbox" class="icheck" name="courier"> Checkbox 3 </label> -->
                                                </div>
                                            </div>
                                            <!-- <select class="form-control" name="courier">
                                            </select> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab4">
                                    <h3 class="block">Confirm registration</h3>
                                    <h4 class="form-section">Store Infomation</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Store Name:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="store_name"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Business Type:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="business_type"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Established Year:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="established_year"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Province:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="province"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">City:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="city"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Contact Person Name:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="contact_person_name"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Contact Person Job Title:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="contact_person_job_title"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Contact Person Phone Number:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="contact_person_phone_number"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Store Description:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="description"> </p>
                                        </div>
                                    </div>
                                    <!-- <h4 class="form-section">Bank Account</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Bank Name:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="bank_name"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Bank Account Number:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="bank_account_number"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Branch:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="branch"> </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Name in Bank Account:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="name_in_bank_account"> </p>
                                        </div>
                                    </div> -->
                                    <h4 class="form-section">Courier Service</h4>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Courier:</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static" data-display="courier[]"> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="fa fa-angle-left"></i> Back </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <button type="submit" class="btn green button-submit"> Submit
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
    {{HTML::script('public/global/plugins/icheck/icheck.min.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    {{ HTML::script('public/js/open_store.js') }}
    <!--END PAGE LEVEL SCRIPTS-->
@endsection