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
 <body>
 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
   <!-- Indicators -->
   <ol class="carousel-indicators">
     <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
     <li data-target="#carousel-example-generic" data-slide-to="1"></li>
     <li data-target="#carousel-example-generic" data-slide-to="2"></li>
   </ol>

   <!-- Wrapper for slides -->
   <div class="carousel-inner" role="listbox">
     <div class="item">
       <img src="{{ asset('/includes/images/server_back1.jpg') }}" alt="...">
       <div class="carousel-caption">
            <h1>Customer Centric Innovation beyond technology boundaries</h1>
       </div>
     </div>
     <div class="item">
       <img src="{{ asset('/includes/images/server_back2.jpg') }}" alt="...">
       <div class="carousel-caption">
         <h1>
Secure Payment Solutions</h1>
       </div>
     </div>
     <div class="item active" >
            <img src="{{ asset('/includes/images/server_back3.jpg') }}" alt="...">
            <div class="carousel-caption">
              <h1>A leader in Omnichannel retail innovation</h1>
            </div>
      </div>

   </div>

   <!-- Controls -->
   <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
     <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
   </a>
   <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
     <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
   </a>
 </div>

@yield('content')
 </body>

 </html>