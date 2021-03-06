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
                       
                <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@update_store_information')}}" id="save_store" method="POST" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control" name="name" value="{{$store_info->store_name}}" readonly/>
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
                                            <select class="form-control" name="province" value="{{$store_info->province}}" id="province">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">City
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="city" value="{{$store_info->city}}" id="city">
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
                                                        <input type="hidden" value="" name="..."><input type="file" name="photo"> </span>
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
                                                        <input type="hidden" value="" name="..."><input type="file" name="banner"> </span>
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
                    <button type="submit" class="btn blue" form="save_store">Save Changes</button>
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
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
                 <form class="form-horizontal" action="" id="submit_form" method="POST">
                {{ csrf_field() }}
                    <div class="form-body">
                        <div class = "row">
                             <div class = "col-md-3">
                             </div>
                            <div class = "col-md-6">
                                    <div class="portlet-body">
                                        @if ($result->ktp != "")
                                         <div class="form-group">
                                            <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">KTP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : submitted yet</span>                    
                                                </div>
                                            </div>
                                        </div>
                                        @else
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
                                        @endif

                                         @if ($result->siup != "")
                                         <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">SIUP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : submitted yet</span>                    
                                                </div>

                                            </div>
                                           
                                          
                                        </div>
                                        @else
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
                                        @endif
                                       

                                        @if ($result->npwp != "")
                                        <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">NPWP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : submitted yet</span>                    
                                                </div>
                                            </div>
                                        </div>

                                        @else
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
                                        @endif

                                        @if ($result->skdp != "")
                                         <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">SKDP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : submitted yet</span>                    
                                                </div>
                                            </div>
                                        </div>

                                        @else
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

                                        @endif

                                         @if ($result->tdp != "")
                                         <div class="form-group">
                                             <div class="col-md-6" >
                                                <div class="col-md-12">
                                                    <div class="control-label" style="text-align: left;">TDP</div>
                                                </div>
                                                <div class="col-md-12" style="text-align: left;">
                                                    <span>Status : submitted yet</span>                    
                                                </div>
                                            </div>  
                                        </div>        
                                         @else
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
                                        @endif

                                       @if ($result->ktp == "" || $result->siup == "" ||$result->npwp == "" ||$result->skdp == "" ||$result->tdp == "" )
                                        <form method="POST" action=""  id="History">
                                            {{ csrf_field() }}
                                            <div class="col-md-2">
                                                <select name="date" class="form-control" value=""  id="date">
                                                    <option value="2018-08">Agustus 2018</option>
                                                    <option value="2018-07">July 2018</option>
                                                    <option value="2018-06">June 2018</option>
                                                    <option value="2018-05">May 2018</option>
                                                </select>  
                                                <input type="text" name="year"  value="" hidden=""> 
                                                <input type="text" name="month" value="" hidden="">        
                                            </div>
                                        </form>
                                         <div class="form-actions">
                                            <div class="col-md-10">
                                                <button  type="submit" class="btn blue" form="History" onclick="reload()">Show History</button>
                                               <br><br>
                                            </div>
                                        </div>

                                       @endif

                                    </div>
                            </div>
                            <div class = "col-md-3">
                             </div>
                        </div>
                    </div>
                </form>
           
            </div>
            <div class="tab-pane" id="tab_3">
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
            
                    <div class="form-body">
                        <div class = "row">
                            <div class = "col-md-12">
                                <div class="form-group" style="text-align: center;">
                                    <div class="col-md-3">
                                    Courier Service                                
                                    </div>
                                   <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@insert_user_store_courier') }}" id="insert_courier" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}

                                            <input type="text" name="store_id" value="{{$result->store_id}}" hidden="">

                                        <div class="col-md-3">
                                            <select name="courier_id" class="form-control" value="">
                                                <option value="1">JNE</option>
                                                <option value="2">POS Indonesia</option>
                                                <option value="3">TIKI</option>
                                            </select>                                    
                                        </div>
                                    </form>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                         <div class="form-actions">
                                           <button type="submit" class="btn blue" form="insert_courier" onclick="refresh()">Add Courier</button><br><br>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group" style="text-align: center;">
                                    
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th style="text-align: center;">Courier Name</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <form class="form-horizontal" action="{{ action('Web_Controller\App2Controller@delete_user_store_courier') }}" id="delete_courier" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @foreach($result->courier_service as $c)
                                                <tr style="text-align: center;">
                                                    <td> {{$c->courier_name}}</td>
                                                    <td> 
                                                        <input type="text" name="courier_id" value="{{$c->courier_id}}" hidden="">

                                                        <input type="text" name="store_id" value="{{$result->store_id}}" hidden="">

                                                        <div class="form-actions">
                                                           <button type="submit" class="btn red" form="delete_courier" >Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                 </form>

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
    <!-- {{ HTML::script('public/js/store_setting.js') }} -->
    <script>
    
        //document.getElementById('business_type').value="{{$store_info->business_type}}";
        // document.getElementById('province').value="{{$store_info->province}}";
        // document.getElementById('city').value="{{$store_info->city}}";

        jQuery(document).ready(function() {
   
            var province_list = null;
            var city_list = null;
            var courier_list = null;
            var province_input = $("select[name='province']");
            var city_input = $("select[name='city']");
            var courier_input = $("#courier_input");

            var province_value = document.querySelector('input[name="province"]');
            var city_value = document.querySelector('input[name="city"]');


            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/api/get_province_list",
                async: false,
                success : function(response) {
                    province_list = response.province;
                    $.each(province_list, function(index, value) {          
                        province_input.append(
                            $('<option></option>').val(value.province_id).html(value.province_name)
                        );
                    });
                },
                error: function() {
                    alert('Error occured');
                }
            });

            province_input.change(function() {
                city_input.empty();
                $.ajax({
                    type:"POST",
                    url : "http://localhost/dress_marketplace/api/get_city_by_province",
                    data : {
                        province_id : $(this).val()
                    },
                    async: false,
                    success : function(response) {
                        city_list = response.city;
                        $.each(city_list, function(index, value) {          
                            city_input.append(
                                $('<option></option>').val(value.city_id).html(value.city_type+" "+value.city_name)
                            );
                        });
                        // var selected = $("select[name='province'] option:selected").val();
                        // province_value.value=selected;
                        // var selected2 = $("select[name='city'] option:selected").val();
                        // city_value.value=selected2;
                    },
                    error: function() {
                        alert('Error occured');
                    }
                });
            });
            
            province_input.val("{{$store_info->province}}");
            province_input.trigger('change');
            city_input.val("{{$store_info->city}}");
            document.getElementById('business_type').value="{{$store_info->business_type}}";

            // city_input.change(function() {
            //     var selected2 = $("select[name='city'] option:selected").val();
            //     city_value.value=selected2;
            // });

            $.ajax({
                type:"POST",
                url : "http://localhost/dress_marketplace/api/get_courier_list",
                async: false,
                success : function(response) {
                    courier_list = response.courier;
                    $.each(courier_list, function(index, value) {          
                        courier_input.append(
                                '<label><input type="checkbox" class="icheck" name="courier[]" data-title="' + value.courier_name +  '" value="' + value.courier_id + '">' + value.courier_name + '</label>'
                        );
                    });
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue'
                    });
                },
                error: function() {
                    alert('Error occured');
                }
            });
        });
      

    </script>
@endsection