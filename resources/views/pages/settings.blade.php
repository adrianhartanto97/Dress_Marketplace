@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}

      {{ HTML::style('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
     {{ HTML::style('public/global/plugins/clockface/css/clockface.css') }}

   
    {{ HTML::style('public/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}




   
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
                    <div class="tabbable-custom">
                        <ul class="nav nav-tabs ">
                            <!-- <li class="active">
                                <a href="#tab_1" data-toggle="tab"> Profile Settings</a>
                            </li> -->
                           <!--  <li>
                                <a href="#tab_2" data-toggle="tab"> Password Settings </a>
                            </li> -->
                            
                        </ul>

                        <div class="tab-content">
                           <!--  <div class="tab-pane active" id="tab_1"> -->
                                <div class="form">
                                <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@psettings') }}" id="submit_form" method="POST" enctype="multipart/form-data">
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
                                                Edit Profile
                                               <!--  <div class="form-group">
                                                    <label class="control-label col-md-4">Change Image <span class="required"> * </span></label>
                                                    <div class="col-md-7">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                                            <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" name="avatar"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Full Name
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="full_name" value="" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Phone Number 
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="phone_number" value="" />
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
                            <!-- </div> -->
                        <!--     <div class="tab-pane" id="tab_2">
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6">
                                                8
                                            </div>
                                            <div class="col-md-6" style="text-align:right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                 
                                </div>

                               
                            </div>
 -->
                            
                        </div>
                    </div>
</div></div></div></div>
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
    {{HTML::script('public/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    {{HTML::script('public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}
    


   
@endsection


