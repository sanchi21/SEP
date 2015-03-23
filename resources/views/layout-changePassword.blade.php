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
        <label for="nav-trigger"></label>
    </div>
    <ul class="nav navbar-nav navbar-right">
          <li><a href="#" style="color: #ffffff">user role: {{Auth::User()->permissions}}</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #ffffff" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{Auth::User()->username }} <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ URL::route('account-change-password') }}">Change Password</a></li>
                <li><a href="{{ URL::route('sign-out') }}">Logout</a></li>
              </ul>
            </li>
          </ul>
  </div>
</nav>

<div class="content_main" style="margin-top: 70px; margin-left: 22%;">
<div class = "container">
    <div class="col-xs-12 col-sm-10 col-md-12 col-lg-7" style="inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
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