<html>
<head>
    <title>Home</title>

{{--styles--}}
 <link href="{{ asset('/includes/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/custom-login.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/bootstrap-multiselect.css') }}" rel="stylesheet">


 {{--styles--}}

 {{--scritps--}}
 <script src="{{ asset('/includes/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap-multiselect.js') }}"></script>
 {{--scritps--}}


    {{--<script type="text/javascript" src = "https://code.jquery.com/jquery.js"></script>--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>--}}
    {{--<script src="http://localhost:8080/includes/js/bootstrap.min.js"></script>--}}

    <script type="text/javascript" src="{{ asset('/includes/js/FormChange.js') }}"></script>


    {{--<link href="http://localhost:8080/includes/css/bootstrap.min.css" rel="stylesheet">--}}


    <link href="{{ asset('/includes/css/resource.css') }}" rel="stylesheet">

</head>
<body style="background-color: rgba(229, 228, 226, 0.5); height:100%; width: 100% " onload="init()">
{{--f1f1f1--}}
<ul class="navigation">
@if(Auth::User()->permissions=="Administrator Full")
        <li class="nav-item"><a href=" {{ URL::route('forgotPassword') }}"><img src="{{asset('/includes/images/icons/home.png')}}" alt="Home" style="width:20px;height:20px">&nbsp;&nbsp;Home</a></li>
        <li class="nav-item"><a href=" {{ URL::route('add-user') }}"><img src="{{asset('/includes/images/icons/users.png')}}" alt="Manage Users" style="width:20px;height:20px">&nbsp;&nbsp;Manage Users</a></li>
        <li class="nav-item"><img src="{{asset('/includes/images/icons/hardware.png')}}" alt="Hardware" style="width:20px;height:20px">&nbsp;&nbsp;Hardware</li>
                <li class="nav-item"><a href=" {{ URL::route('hardware') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/add.png')}}" alt="New Hardware" style="width:18px;height:18px">&nbsp;&nbsp;New Hardware</a></li>
                <li class="nav-item"><a href=" {{ URL::route('hardware-edit-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Edit Hardware</a></li>

        <li class="nav-item"><img src="{{asset('/includes/images/icons/software.png')}}" alt="Software" style="width:20px;height:20px">&nbsp;&nbsp;Software</li>
                <li class="nav-item"><a href=" {{ URL::route('software-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/add.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;New Software</a></li>
                <li class="nav-item"><a href=" {{ URL::route('software-edit-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Edit Software</a></li>
        <li class="nav-item"><a href=" {{ URL::route('hardware-edit-get') }}"><img src="{{asset('/includes/images/icons/options.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Options</a></li>
@else
        <li class="nav-item"><img src="{{asset('/includes/images/icons/software.png')}}" alt="Software" style="width:20px;height:20px">&nbsp;&nbsp;Requests</li>
                <li class="nav-item"><a href=" {{ URL::route('hardwarereq') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/add.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;Resources</a></li>
                <li class="nav-item"><a href=" {{ URL::route('ftpreq') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;FTP Account</a></li>
   @endif
  </ul>
<input type="checkbox" id="nav-trigger" class="nav-trigger"/>

<div class="site-wrap">

<!--NavBar-->
<nav class="navbar navbar-default navbar-fixed-top" style="background-color: rgba(0, 155, 179, 0.9); opacity: 0.93">
  <div class="container-fluid">
    <div class="navbar-header">
        <img src="{{ asset('/includes/images/zone_logo.png') }}" style="width: 168px; height: 50.6px">
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

{{--<script src="http://listjs.com/no-cdn/list.js"></script>--}}
</body>
</html>