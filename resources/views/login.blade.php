<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Dress Marketplace - Login Page</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
        
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
<!--
        <div class="logo">
            <a href="index.html">
                <img src="../assets/pages/img/logo-big.png" alt="" /> </a>
        </div>
-->
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" method="post" action="{{ action('Web_Controller\UserController@login') }}" >
                {{ csrf_field() }}
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                @if (session('status'))
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>{{ session('status') }}</span>
                    </div>
                @elseif (session()->has('register_status') && session()->get('register_status') == true)
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button>
                        <span>{{ session('register_message')}}</span>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('.register-form').hide();
                            $('.login-form').show();                                                       
                        });     
                    </script>
                @endif
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}"/> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" value="{{ old('password') }}" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>
<!--
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
-->
<!--                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>-->
                </div>
<!--
                <div class="login-options">
                    <h4>Or login with</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul>
                </div>
-->
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
<!--
            <form class="forget-form" action="index.html" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
-->
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="{{ action('Web_Controller\UserController@register') }}" method="post">
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
                        <a href="{{url('/terms_of_service')}}" target="_blank">Terms of Service </a> &
                        <a href="{{url('/privacy_policy')}}" target="_blank">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM -->
        </div>
<!--        <div class="copyright"> 2014 © Metronic. Admin Dashboard Template. </div>-->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
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
    </body>

</html>