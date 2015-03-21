<?php
/**
 * User: abhayan s
 * Date: 3/21/2015
 * Time: 5:56 AM
 */ ?>

 <html>
 <head>
 <title>
    Sign In
 </title>
 {{--styles--}}
 <link href="{{ asset('/includes/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/custom-login.css') }}" rel="stylesheet">


 {{--styles--}}

 {{--scritps--}}
 <script src="{{ asset('/includes/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap.min.js') }}"></script>
 {{--scritps--}}
 </head>
 <body style="background-color: #e7e7e7;">
@yield('content')
 </body>

 </html>