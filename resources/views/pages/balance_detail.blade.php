@extends('layout')

@section('css')
    {{ HTML::style('public/global/plugins/fancybox/source/jquery.fancybox.css') }}
    {{ HTML::style('public/star-rating-svg-master/src/css/star-rating-svg.css') }}
    {{ HTML::style('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ HTML::style('public/css/iconeffects.css')}}
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}
    {{ HTML::style('public/global/plugins/font-awesome/css/font-awesome.min.css')}}
    {{ HTML::style('public/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap/css/bootstrap.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {{ HTML::style('public/global/plugins/datatables/datatables.min.css')}}
    {{ HTML::style('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}
    {{ HTML::style('public/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}   
    {{ HTML::style('public/global/plugins/clockface/css/clockface.css')}}   
        <!-- END PAGE LEVEL PLUGINS -->    <!-- BEGIN THEME GLOBAL STYLES -->
    {{ HTML::style('public/global/css/components.min.css')}}
    {{ HTML::style('public/global/css/plugins.min.css')}}
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    {{ HTML::style('public/layouts/layout/css/layout.min.css')}}
    {{ HTML::style('public/layouts/layout/css/themes/darkblue.min.css')}}
    {{ HTML::style('public/layouts/layout/css/custom.min.css')}}
    <!-- END THEME LAYOUT STYLES -->
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
                                 <button type="button" class="btn blue btn-lg" data-toggle="modal" href="#withdraw" >Withdraw</button>                                  
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
                                                            <input type="text" class="form-control" name="withdraw_amount" placeholder="withdraw_amount" />
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
                                                            <input type="text" class="form-control" name="bank_account_number" placeholder="bank_account_number"/>
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

    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}
    {{HTML::script('public/star-rating-svg-master/src/jquery.star-rating-svg.js')}}
    {{HTML::script('public/global/plugins/fuelux/js/spinner.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js')}}
    <!--END PAGE LEVEL PLUGINS-->

    <!--BEGIN PAGE LEVEL PLUGINS-->
    {{HTML::script('public/global/plugins/jquery.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap/js/bootstrap.min.js')}}
    {{HTML::script('public/global/plugins/js.cookie.min.js')}}
    {{HTML::script('public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
    {{HTML::script('public/global/plugins/jquery.blockui.min.js')}}
    {{HTML::script('public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {{HTML::script('public/global/scripts/datatable.js')}}
        <!-- {{HTML::script('public/global/plugins/datatables/datatables.min.js')}}
        {{HTML::script('public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}} -->
        {{HTML::script('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
        
        {{HTML::script('public/global/plugins/moment.min.js')}}
         {{HTML::script('public/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}
        {{HTML::script('public/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
        {{HTML::script('public/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}
        {{HTML::script('public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}
        {{HTML::script('public/global/plugins/clockface/js/clockface.js')}}
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {{HTML::script('public/global/scripts/app.min.js')}}
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        {{HTML::script('public/pages/scripts/table-datatables-buttons.min.js')}}
        {{HTML::script('public/pages/scripts/components-date-time-pickers.min.js')}}

        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        {{HTML::script('public/layouts/layout/scripts/layout.min.js')}}
        {{HTML::script('public/layouts/layout/scripts/demo.min.js')}}
        {{HTML::script('public/layouts/global/scripts/quick-sidebar.min.js')}}
        {{HTML::script('public/layouts/global/scripts/quick-nav.min.js')}}
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