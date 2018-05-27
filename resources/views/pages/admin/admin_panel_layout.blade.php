<html>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <head>
        <title>Admin Page Dress Marketplace</title>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />  
        {{ HTML::style('public/global/plugins/font-awesome/css/font-awesome.min.css') }}
        {{ HTML::style('public/global/plugins/simple-line-icons/simple-line-icons.min.css') }}
        {{ HTML::style('public/global/plugins/bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('public/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}
        <!-- END GLOBAL MANDATORY STYLES -->
        
        <!-- BEGIN THEME GLOBAL STYLES -->
        {{ HTML::style('public/global/css/components.min.css') }}
        {{ HTML::style('public/global/css/plugins.min.css') }}
        <!-- END THEME GLOBAL STYLES -->
        
        <!-- BEGIN THEME LAYOUT STYLES -->
        {{ HTML::style('public/layouts/layout/css/layout.min.css') }}
        {{ HTML::style('public/layouts/layout/css/themes/darkblue.min.css') }}
        {{ HTML::style('public/layouts/layout/css/custom.min.css') }}
        <!-- END THEME LAYOUT STYLES -->

        <!-- BEGIN CORE PLUGINS -->
        {{ HTML::script('public/global/plugins/jquery.min.js') }}
        {{ HTML::script('public/global/plugins/bootstrap/js/bootstrap.min.js') }}
        {{ HTML::script('public/global/plugins/js.cookie.min.js') }}
        {{ HTML::script('public/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
        {{ HTML::script('public/global/plugins/jquery.blockui.min.js') }}
        {{ HTML::script('public/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}
        <!-- END CORE PLUGINS -->
        
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        {{ HTML::script('public/global/scripts/app.min.js') }}
        <!-- END THEME GLOBAL SCRIPTS -->
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        {{ HTML::script('public/layouts/layout/scripts/layout.min.js') }}
        {{ HTML::script('public/layouts/layout/scripts/demo.min.js') }}
        {{ HTML::script('public/layouts/global/scripts/quick-sidebar.min.js') }}
        {{ HTML::script('public/layouts/global/scripts/quick-nav.min.js') }}
        <!-- END THEME LAYOUT SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="#">
                            <h3 style="color:white; margin:10px;">Admin Page</h3>
                            <!-- <img src="../assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" />  -->
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="{{url('/admin/logout')}}" style="color:white">
                                    <span class="username"> <b>Logout</b> </span>
                                    <i class="icon-logout"></i>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <div class="clearfix"> </div>
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            
                            <li class="nav-item @if($active_nav == 'manage_store')active @else @endif">
                                <a href="{{url('/admin/manage_store')}}" class="nav-link">
                                    <i class="icon-settings"></i>
                                    <span class="title">Manage Store</span>
                                    <span class="@if($active_nav == 'manage_store')selected @else arrow @endif"></span>
                                </a>
                            </li>
                            <li class="nav-item @if($active_nav == 'manage_product')active @else @endif">
                                <a href="{{url('/admin/manage_product')}}" class="nav-link">
                                    <i class="icon-settings"></i>
                                    <span class="title">Manage Product</span>
                                    <span class="@if($active_nav == 'manage_product')selected @else arrow @endif"></span>
                                </a>
                            </li>
                            <li class="nav-item @if($active_nav == 'manage_user')active @else @endif">
                                <a href="{{url('/admin/manage_user')}}" class="nav-link">
                                    <i class="icon-settings"></i>
                                    <span class="title">Manage User</span>
                                    <span class="@if($active_nav == 'manage_user')selected @else arrow @endif"></span>
                                </a>
                            </li>
                            <li class="nav-item @if($active_nav == 'verify_payment')active @else @endif">
                                <a href="index.html" class="nav-link">
                                    <i class="icon-settings"></i>
                                    <span class="title">Verify Payment</span>
                                    <span class="@if($active_nav == 'verify_payment')selected @else arrow @endif"></span>
                                </a>
                            </li>
                            <li class="nav-item @if($active_nav == 'algo')active @else @endif">
                                <a href="index.html" class="nav-link">
                                    <i class="icon-settings"></i>
                                    <span class="title">FFA - PSNN Algorithm</span>
                                    <span class="@if($active_nav == 'algo')selected @else arrow @endif"></span>
                                </a>
                            </li>\
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->

                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        @yield('content')
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
        @yield('script')
    </body>
</html>