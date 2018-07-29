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
                    <span class="caption-subject font-red bold uppercase"> Checkout -
                        <span class="step-title"> Step 1 of 3 </span>
                    </span>
                </div>   
            </div>
            <div class="portlet-body form">
                <form action="{{ action('Web_Controller\AppController@checkout') }}" id="submit_form" method="POST">
                {{ csrf_field() }}
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Choose Address </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" id="tab2_click" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Choose Courier Service </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab3" data-toggle="tab" class="step">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Payment </span>
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
                                    <h3 class="block">Choose Address</h3>
                                    <div class = "row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Receiver Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-10 input-group">
                                                    <input type="text" class="form-control" name="receiver_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Address
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-10 input-group">
                                                    <textarea type="text" class="form-control" name="address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Province
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-10 input-group">
                                                    <select class="form-control" name="province">
                                                        @foreach ($province as $p)
                                                            <option value="{{$p->province_id}}">{{$p->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>City
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-10 input-group">
                                                    <select class="form-control" name="city">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8 input-group">
                                                    <input type="text" class="form-control" name="phone_number">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code
                                                </label>
                                                <div class="col-md-8 input-group">
                                                    <input type="text" class="form-control" name="postal_code">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab2">
                                    <div id="tab2_container">
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class="col-md-7" style="font-size:16px;">
                                                    <div class="col-md-6">
                                                        <i class="fa fa-money"></i> Your Cash :
                                                    </div>
                                                    <div class="col-md-6" style="text-align : right" id="available_points">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:20px;">   
                                                <label class="col-md-3">Use Cash</label>
                                                <div class="col-md-7" >
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-money"></i>
                                                            </span>
                                                            <input type="text" class="form-control" name="use_point"> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="row">
                                                <h2 id="total_price"></h2>
                                            </div>
                                            <div class="row">
                                                <h4 id="subtotal_price"></h4>
                                            </div>
                                            <div class="row">
                                                <h4 id="shipping_price"></h4>
                                            </div>
                                            <div class="row">
                                                <h4 id="use_point" style="display: none;"></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-7">
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="fa fa-angle-left"></i> Back </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <button type="submit" class="btn green button-submit" id="submit_button"> Submit
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
    <script>
        var global_total_price = 0;
    </script>
    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/select2/js/select2.full.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{HTML::script('public/global/plugins/icheck/icheck.min.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL SCRIPTS-->
    {{ HTML::script('public/js/checkout.js') }}
    <!--END PAGE LEVEL SCRIPTS-->

    <script>
        function myFunction(select, store_id)
        {
            var opt = select.options[select.selectedIndex];
            var courier_id = opt.getAttribute("data-courier-id");
            var courier_service = opt.getAttribute("data-courier-service");

            $('#courier_id_'+store_id).val(courier_id);
            $('#courier_service_'+store_id).val(courier_service);
            //console.log(courier_id);
        }

        $("select").each(function() {
            //$( this ).trigger('change');
            // var opt = this.options[this.selectedIndex];
            // var courier_id = opt.getAttribute("data-courier-id");
            // var store_id = this.getAttribute("data-store-id");

            //console.log($( this ));
            
            //$('#courier_id_'+store_id).val(courier_id);
        });

        $("input[name='use_point']").keyup(function() {
            var point = $(this).val() || 0;
            
            $("h4#use_point").text("Use Cash : - IDR " + point.toLocaleString()).show();

            var tmp_total_price = global_total_price - parseInt(point);

            $('#total_price').text('Total Price : IDR ' + tmp_total_price.toLocaleString());

            if (point > balance || point > global_total_price) {
                $('#submit_button').prop('disabled', true);
            }
            else {
                $('#submit_button').prop('disabled', false);
            }
        });
    </script>
@endsection