<html>
<head>
    <title>Home</title>



    <script type="text/javascript" src = "https://code.jquery.com/jquery.js"></script>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>--}}
    <script src="http://localhost:8080/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/resources/views/ManageResource/FormChange.js"></script>


    <link href="http://localhost:8080/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <link href="http://localhost:8080/resources/views/ManageResource/resource.css" rel="stylesheet">

</head>
<body style="background-color: rgba(229, 228, 226, 0.5); height:100%; width: 100% " onload="init()">
{{--f1f1f1--}}
<ul class="navigation">
        <li class="nav-item"><a href="http://localhost:8080/hardware">Hardware</a></li>
        <li class="nav-item"><a href="http://localhost:8080/software">Software</a></li>
        <li class="nav-item"><a href="http://localhost:8080/software-edit">Software Edit</a></li>
        <li class="nav-item"><a href="">soflsdkfn</a></li>
  </ul>
<input type="checkbox" id="nav-trigger" class="nav-trigger"/>

<div class="site-wrap">

<!--NavBar-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: rgba(0, 155, 179, 0.9); opacity: 0.93">
  <div class="container-fluid">
    <div class="navbar-header">
        <img src="http://localhost:8080/resources/views/images/zone_logo.png" style="width: 168px; height: 50.6px">
        <label for="nav-trigger"></label>
    </div>
    <div class="container">

    </div>
  </div>
</nav>


<div class="collapse" id="content_left" style="float: left; width: 18%; margin-top: 50px; background-color: #ffffff; position: fixed">

  </div>




<br>
<br>
<div id="content_main">
    <div class="panel panel-default" style="width: 100%; overflow: auto">
      <div class="panel-body">
        @if(Session::has('flash_message'))
        <div class="alert alert-success">
        {{Session::get('flash_message')}}
        </div>
        @elseif(Session::has('flash_message_error'))
                <div class="alert alert-danger">
                {{Session::get('flash_message_error')}}
                </div>
        @endif
       @yield('content')
      </div>
      <script>
        $('div.alert').delay(3000).slideUp(300);
      </script>
    </div>
</div>

</div>


</body>
</html>