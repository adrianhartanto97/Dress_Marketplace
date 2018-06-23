@extends('layout')

@section('css')


    {{ HTML::style('public/global/plugins/font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('public/global/plugins/simple-line-icons/simple-line-icons.min.css') }}
    {{ HTML::style('public/global/plugins/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {{ HTML::style('public/global/plugins/select2/css/select2.min.css') }}
    {{ HTML::style('public/global/plugins/select2/css/select2-bootstrap.min.css') }}
    <!-- END PAGE LEVEL PLUGINS -->
    
    <!-- BEGIN THEME GLOBAL STYLES -->
    {{ HTML::style('public/global/css/components.min.css') }}
    {{ HTML::style('public/global/css/plugins.min.css') }}
    <!-- END THEME GLOBAL STYLES -->
    
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{ HTML::style('public/pages/css/login.min.css') }}
    <!-- END PAGE LEVEL STYLES -->
    
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    {{ HTML::script('public/global/plugins/jquery.min.js') }}

    {{ HTML::style('public/global/plugins/datatables/datatables.min.css')}}
   
    <!-- file:///D:/Tes/TUGAS%20AKHIR/metronic_v4.7.5/theme/admin_1/table_datatables_buttons.html -->
   
       
    <style>
       a {
           text-decoration:none;
       }
    </style>
@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row" style="padding:0px 10px;">
                @include('layout.user_sidebar',['login_info' => $login_info])

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
                  
  
                        <div class="form-group">
                            <div class="col-md-12">
                                <h1>Balance : IDR {{ number_format($login_info->user_info->balance,0,",",".") }} </h1>
                                 <button type="button" class="btn blue btn-lg" data-toggle="modal" href="#withdraw3" >Withdraw</button>                                  
                            </div>
                           
                        </div>
                        
                
                        <!--begin modal -->
                        <div class="modal fade bs-modal-sm" id="withdraw" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:center;">
                                                <form method="post" action="#" class="form-horizontal" id="form1">
                                                    <input type="hidden" name="product_id" value="">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Balance
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="balance" value="IDR {{ number_format($login_info->user_info->balance,0,",",".") }}" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Withdraw Amount
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="amount" placeholder="withdraw_amount" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Bank Name
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="bank_name" placeholder="bank_name" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Bank Account Number
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="account_number" placeholder="bank_account_number"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Branch
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="branch" placeholder="branch" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Name in Bank Account
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="name_in_bank_acount" placeholder="name_in_bank_acount" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Your Password
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="password" class="form-control" name="password" placeholder="password" />
                                                        </div>
                                                    </div>
                                                                    
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                        <button type="submit" id="btn_submit" class="btn red" form="form1">Submit</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!--end modal -->

                        <!--begin modal -->
                        <div class="modal fade bs-modal-sm" id="withdraw2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                         <form class="register-form" form="form2" action="{{ action('Web_Controller\App2Controller@withdraw') }}" method="post">
                                            {{ csrf_field() }}
                                            @if (session()->has('status') && session()->get('status') == false)
                                                <div class="alert alert-danger">
                                                    <button class="close" data-close="alert"></button>
                                                    <span>{{ session('message')}}</span>
                                                </div>
                                                
                                            @endif
                                             
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <span class="hint">Balance</span>
                                                </div>
                                                <div class="col-md-6">
                                                    
                                                    <input type="text" class="form-control" name="balance" value="IDR {{ number_format($login_info->user_info->balance,0,",",".") }}" readonly/>
                                                    <br>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Withdraw Amount</span>
                                                     <span class="required"> * </span>

                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Withdraw Amount</label>

                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Withdraw Amount" name="amountr" value="{{ old('amount') }}"/> <br>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Bank Name</span>
                                                    <span class="required"> * </span>
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Bank Name</label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Bank Name" name="bank_name" value="{{ old('bank_name') }}"/> <br>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Branch</span>
                                                    <span class="required"> * </span>
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Branch</label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Branch" name="branch" value="{{ old('branch') }}"/> <br>
                                                </div>

                                            </div>

                                             <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Account Number</span>
                                                    <span class="required"> * </span>
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Account Number</label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Account Number" name="account_number" value="{{ old('account_number') }}"/> <br>
                                                </div>

                                            </div>

                                             <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Name in bank account</span>
                                                    <span class="required"> * </span>
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Name in bank Account</label>
                                                <input class="form-control placeholder-no-fix" type="text" placeholder="Name in bank Account" name="name_in_bank_acount" value="{{ old('name_in_bank_acount') }}"/> <br>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4">
                                                     <span class="hint">Password</span>
                                                    <span class="required"> * </span>
                                                </div>
                                                 <div class="col-md-6">
                                                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                                                    <input class="form-control placeholder-no-fix" type="password" placeholder="Password" name="password" value="{{ old('password') }}"/> <br>
                                                </div>
                                            </div>

                                            <div class="form-group margin-top-20 margin-bottom-20">
                                                <label class="mt-checkbox mt-checkbox-outline">
                                                    <input type="checkbox" name="tnc" /> I agree to the
                                                    <a href="javascript:;">Terms of Service </a> &
                                                    <a href="javascript:;">Privacy Policy </a>
                                                    <span></span>
                                                </label>
                                                <div id="register_tnc_error"> </div>
                                            </div>
                                            
                                            <div class="form-actions">
                                                <button type="button"  class="btn green btn-outline" data-dismiss="modal">Cancel</button>
                                                <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
                                            </div>  
                                        </form>
                                        <!-- END REGISTRATION FORM -->
                                    </div>
                                   
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!--end modal -->

                       
                         <div class="modal fade bs-modal-sm" id="withdraw3" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:center;">
                                               <form class="register-form"  action="{{ action('Web_Controller\UserController@register') }}" method="post" >
                                                    {{ csrf_field() }}
                                                    <h3 class="font-green">Sign Up</h3>
                                                    @if (session()->has('register_status') && session()->get('register_status') == false)
                                                        <div class="alert alert-danger">
                                                            <button class="close" data-close="alert"></button>
                                                            <span>{{ session('register_message')}}</span>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('.login-form').hide();
                                                                $('.register-form').show();
                                                                $('#gender').val('{{old('gender')}}');
                                                            });     
                                                        </script>
                                                    @endif
                                                    <p class="hint"> Enter your personal details below: </p>
                                                    
                                                    <div class="form-group">
                                                        <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                                                        <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="full_name" value="{{ old('full_name') }}"/> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label visible-ie8 visible-ie9">Gender</label>
                                                        <select name="gender" class="form-control" value="{{ old('gender') }}" id="gender">
                                                            <option value="">Select Gender</option>
                                                            <option value="M">Male</option>
                                                            <option value="F">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label visible-ie8 visible-ie9">Phone Number</label>
                                                        <input class="form-control placeholder-no-fix" type="text" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}"/> 
                                                    </div>
                                                    
                                                    <p class="hint"> Enter your account details below: </p>
                                                    <div class="form-group">
                                                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                                        <label class="control-label visible-ie8 visible-ie9">Email</label>
                                                        <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="register_email" value="{{ old('register_email') }}" /> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                                                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="register_password" /> </div>
                                                    <div class="form-group">
                                                        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                                                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                                                    <div class="form-group margin-top-20 margin-bottom-20">
                                                        <label class="mt-checkbox mt-checkbox-outline">
                                                            <input type="checkbox" name="tnc" /> I agree to the
                                                            <a href="javascript:;">Terms of Service </a> &
                                                            <a href="javascript:;">Privacy Policy </a>
                                                            <span></span>
                                                        </label>
                                                        <div id="register_tnc_error"> </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                                                        <button type="submit" id="register-submit-btn"  class="btn btn-success uppercase pull-right">Submit</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!--end modal -->
                        <div class="form-group">
                            <div class="col-md-12" style="padding-top: 80px">
                                <h2>Transaction History</h2>
                             
                            </div>

                        </div>
                       
                       
                        <div class="form-group">
                             
                            <div class="col-md-2">
                                <select name="gender" class="form-control" value="" id="History">
                                    <option value="May">This Month</option>
                                    <option value="June">Last Month</option>
                                    <option value="July">2 Months Ago</option>
                                </select>                                    
                            </div>
                            <div class="col-md-10">
                                <button type="button" class="btn blue" data-toggle="modal" href="" >Show History</button>
                                                        <br><br>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Transaction</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Balance</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> Trident </td>
                                                    <td> Internet Explorer 4.0 </td>
                                                    <td> Win 95+ </td>
                                                    <td> 4 </td>
                                                    <td> X </td>
                                                    <td> X </td>

                                                </tr>
                                                <tr>
                                                    <td> Trident </td>
                                                    <td> Internet Explorer 5.0 </td>
                                                    <td> Win 95+ </td>
                                                    <td> 5 </td>
                                                    <td> X </td>
                                                    <td> C </td>
                                                </tr>
                                               
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
       
 
    {{HTML::script('public/pages/scripts/table-datatables-buttons.min.js')}}
  <!-- BEGIN CORE PLUGINS -->
        {{ HTML::script('public/global/plugins/jquery.min.js') }}
        {{ HTML::script('public/global/plugins/bootstrap/js/bootstrap.min.js') }}
        {{ HTML::script('public/global/plugins/js.cookie.min.js') }}
        {{ HTML::script('public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
        {{ HTML::script('public/global/plugins/jquery.blockui.min.js') }}
        {{ HTML::script('public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}
        <!-- END CORE PLUGINS -->
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {{ HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js') }}
        {{ HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js') }}
        {{ HTML::script('public/global/plugins/select2/js/select2.full.min.js') }}
        <!-- END PAGE LEVEL PLUGINS -->
        
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {{ HTML::script('public/global/scripts/app.min.js') }}
        <!-- END THEME GLOBAL SCRIPTS -->
        
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        {{ HTML::script('public/pages/scripts/login.js') }}
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
   
        
@endsection
