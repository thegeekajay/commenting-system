<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.19.3/css/semantic.min.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    </head>
    <body>



        @yield('content')


        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


        @yield('script')
    </body>
</html>