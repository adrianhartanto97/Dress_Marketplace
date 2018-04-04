<html>
    <head>
        <title>Dress Marketplace</title>
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
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-full-width">
        <div class="page-wrapper">
            @include('layout.header',['login' => $login])
            <div class="clearfix"> </div>
            <div class="page-container">
                @yield('content')
            </div>
        </div>
    </body>
</html>