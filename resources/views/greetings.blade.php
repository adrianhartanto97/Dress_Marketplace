<html>
    <head>
        <title>Dress Marketplace</title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        {{ HTML::style('public/global/plugins/font-awesome/css/font-awesome.min.css') }}
        <!-- END GLOBAL MANDATORY STYLES -->
    </head>
    <body>
        @include('layout.header',['login' => $login])
        <h1>Hello, {{ $name }}</h1>
    </body>
</html>