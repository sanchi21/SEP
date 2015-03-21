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

<!--NavBar-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: rgba(0, 155, 179, 0.9); opacity: 0.93">
  <div class="container-fluid">
    <div class="navbar-header">
         <img src="{{ asset('/includes/images/zone_logo.png') }}" style="width: 168px; height: 50.6px">
    </div>
  </div>
</nav>

<div class="content_main" style="margin-top: 70px;">
<div class = "container">
    <div class="col-xs-12 col-sm-10 col-md-12 col-lg-12" style="inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
        <div class="panel panel-default">
           <div class="panel-body">
                @yield('content')
           </div>
         </div>
    </div>
</div>
</div>
 </body>

 </html>