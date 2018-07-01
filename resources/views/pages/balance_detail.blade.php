@extends('layout')

@section('css')
      
    {{ HTML::style('public/global/plugins/select2/css/select2.min.css') }}
    {{ HTML::style('public/global/plugins/select2/css/select2-bootstrap.min.css') }}
   
    
  
    {{ HTML::style('public/pages/css/login.min.css') }}
  
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
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">

        <div class="row" style="padding:0px 10px;">
            @include('layout.user_sidebar',['login_info' => $login_info])
            <div class="col-xs-12 col-sm-9 col-md-10" >
                    <div class="tab-content">
                         <div class="form-group">
                            <div class="col-md-12">
                                <h1>Balance : IDR {{ number_format($login_info->user_info->balance,0,",",".") }} </h1>
                                 <button type="button" class="btn blue btn-lg" data-toggle="modal" href="#withdraw1" >Withdraw</button>                                  
                            </div>
                        </div>
                       
                        <div class="modal fade bs-modal-sm" id="withdraw1" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:center;">
                                                <form method="post" action="{{ action('Web_Controller\App2Controller@balance_withdraw') }}" class="form-horizontal" id="form1">
                                                    {{ csrf_field() }}
                                                    @if (session()->has('withdraw_status') && session()->get('withdraw_status') == false)
                                                        <div class="alert alert-danger">
                                                             <button class="close" data-close="alert"></button>
                                                             <span>{{ session('withdraw_message')}}</span> 
                                                        </div>
                                                        
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#withdraw1').modal('show')                                       
                                                            });     
                                                        </script>  
                                                    @endif 
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Balance
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="balance" value="IDR {{ number_format($login_info->user_info->balance,0,",",".") }}" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Withdraw Amount
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="amount" placeholder="withdraw_amount" value="{{ old('amount') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Bank Name
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="bank_name" placeholder="bank_name" value="{{ old('bank_name') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Bank Account Number
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="account_number" placeholder="bank_account_number" value="{{ old('account_number') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Branch
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="branch" placeholder="branch" value="{{ old('branch') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Name in Bank Account
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control form-control-solid placeholder-no-fix" name="name_in_account" placeholder="Name in Bank Account" value="{{ old('name_in_account') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Your Password
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-7">
                                                            <input type="password" class="form-control form-control-solid placeholder-no-fix" name="password" placeholder="password" />
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn red">Login</button>
                                                         
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


                        <div class="modal fade bs-modal-sm" id="withdraw2" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Withdraw</h4>
                                    </div>
                                    <div class="modal-body">
                                         <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN VALIDATION STATES-->
                                                <div class="portlet light portlet-fit portlet-form bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-bubble font-green"></i>
                                                            <span class="caption-subject font-green bold uppercase">Validation Using Icons</span>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="btn-group">
                                                                <a class="btn green btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a href="javascript:;"> Option 1</a>
                                                                    </li>
                                                                    <li class="divider"> </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 2</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 3</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;">Option 4</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <!-- BEGIN FORM-->
                                                        <form action="#" id="form_sample_2" class="form-horizontal">
                                                            <div class="form-body">
                                                                <div class="alert alert-danger display-hide">
                                                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                                                <div class="alert alert-success display-hide">
                                                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                                                <div class="form-group  margin-top-20">
                                                                    <label class="control-label col-md-3">Name
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="name" /> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Email
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="email" /> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">URL
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="url" /> </div>
                                                                        <span class="help-block"> e.g: http://www.demo.com or http://demo.com </span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Number
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="number" /> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Digits
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="digits" /> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3">Credit Card
                                                                        <span class="required"> * </span>
                                                                    </label>
                                                                    <div class="col-md-4">
                                                                        <div class="input-icon right">
                                                                            <i class="fa"></i>
                                                                            <input type="text" class="form-control" name="creditcard" /> </div>
                                                                        <span class="help-block"> e.g: 5500 0000 0000 0004 </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-9">
                                                                        <button type="submit" class="btn green">Submit</button>
                                                                        <button type="button" class="btn default">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <!-- END FORM-->
                                                    </div>
                                                </div>
                                                <!-- END VALIDATION STATES-->
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
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
                                <button type="button" class="btn blue" data-toggle="modal" href="" >Show History</button><br><br>
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
</div>
@endsection

@section('script')

        {{HTML::script('public/pages/scripts/table-datatables-buttons.min.js')}}
      
       
        {{ HTML::script('public/global/plugins/jquery-validation/js/jquery.validate.min.js') }}
        {{ HTML::script('public/global/plugins/jquery-validation/js/additional-methods.min.js') }}
        {{ HTML::script('public/global/plugins/select2/js/select2.full.min.js') }}
        
        {{ HTML::script('public/global/scripts/app.min.js') }}
        
        {{ HTML::script('public/pages/scripts/login.js') }}
       
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