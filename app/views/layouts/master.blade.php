<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 

<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Blog</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{ HTML::style('css/bootstrap.min.css') }}

       {{-- <style>
                          body {
                              padding-top: 50px;
                              padding-bottom: 20px;
                          }
                      </style>--}}

        @yield('styles')
        @yield('style')

        {{ HTML::style('css/main.css') }}

        {{ HTML::script('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') }}
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        @yield('header')

        <div class="container">
          @yield('content')
        </div> {{-- /container --}}

        {{HTML::script('js/vendor/jquery-1.11.1.min.js')}}
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        {{HTML::script('js/vendor/bootstrap.min.js')}}

        {{-- External library scripts
          -- ========================
          -- Output example:
          -- <script src="js/vendor/jquery-1.11.1.min.js"></script>
          -- <script src="js/vendor/choosen.jquery.min.js"></script> --}}
        @yield('scripts')

        {{HTML::script('js/main.js')}}

        {{-- On page executed script
          -- =======================
          -- Output example:
          -- <script>
          -- $('#someid').plugins();
          -- </script> --}}
        @yield('script')

        {{-- Google Analytics: change UA-XXXXX-X to be your site's ID. --}}
        {{-- <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script> --}}
    </body>
</html>
