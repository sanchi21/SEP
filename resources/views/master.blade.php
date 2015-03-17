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
<body style="background-color: #f1f1f1; height:100%; width: 100% ">

<!--NavBar-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: rgba(0, 155, 179, 0.9); opacity: 0.93">
  <div class="container-fluid">
    <div class="navbar-header">
        <img src="images/logo/zone_logo.png" style="width: 168px; height: 50.6px">
    </div>
    <div class="container">

        <button class="btn btn-primary" id="btnCollapse" type="button" data-toggle="collapse" data-target="#content_left" aria-expanded="false" aria-controls="content_left" style="background-color: #27a9bd; border: 0; height: 50px; margin-left: 20px; ">
        <span class="glyphicon glyphicon-align-justify" id="btnCollapse" style="font-size: 20px"></span>
        </button>
    </div>
  </div>
</nav>


<div class="collapse" id="content_left" style="float: left; width: 18%; margin-top: 50px; background-color: #ffffff; position: fixed">
  <div class="well" style="background-color: #ffffff; height: 600px">
        soflsdkfn<br>
        soflsdkfn<br>
        soflsdkfn<br>
        soflsdkfn<br>
        soflsdkfn<br>soflsdkfn<br>
        soflsdkfn<br>

  </div>
</div>



</div>
<br>
<br>
<div id="content_main" style="float:right; width: 80%;">
    <div class="panel panel-default" style="width: 100%">
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

</body>
</html>