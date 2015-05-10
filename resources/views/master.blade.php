<html>
<head>
    <title>Zone 24x7 - Resource Allocation System</title>

{{--styles--}}
 <link href="{{ asset('/includes/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/custom-login.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/bootstrap-multiselect.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/bootstrapDatetimepicker.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/resource.css') }}" rel="stylesheet">



 {{--styles--}}

 {{--scritps--}}
 <script src="{{ asset('/includes/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap-multiselect.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrapDatetimepicker.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/FormChange.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/validate.js') }}"></script>
 {{--scritps--}}





    {{--<link href="http://localhost:8080/includes/css/bootstrap.min.css" rel="stylesheet">--}}




</head>
<body style="background-color: rgba(229, 228, 226, 0.5); height:100%; width: 100% " onload="init()">
{{--f1f1f1--}}
<ul class="navigation">
@if(Auth::User()->username!="srinithy")
        <li class="nav-item"><a href=" {{ URL::route('home-admin-full') }}"><img src="{{asset('/includes/images/icons/home.png')}}" alt="Home" style="width:20px;height:20px">&nbsp;&nbsp;Home</a></li>
        <li class="nav-item"><a href=" {{ URL::route('add-user') }}"><img src="{{asset('/includes/images/icons/users.png')}}" alt="Manage Users" style="width:20px;height:20px">&nbsp;&nbsp;Manage Users</a></li>
        <li class="nav-item"><img src="{{asset('/includes/images/icons/hardware.png')}}" alt="Hardware" style="width:20px;height:20px">&nbsp;&nbsp;Hardware</li>
                <li class="nav-item"><a href=" {{ URL::route('hardware') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/add.png')}}" alt="New Hardware" style="width:18px;height:18px">&nbsp;&nbsp;New Hardware</a></li>
                <li class="nav-item"><a href=" {{ URL::route('hardware-edit-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Edit Hardware</a></li>
                <li class="nav-item"><a href=" {{ URL::route('change-property/New') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Attributes</a></li>
                <li class="nav-item"><a href=" {{ URL::route('change-options') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Drop Downs</a></li>

        <li class="nav-item"><img src="{{asset('/includes/images/icons/software.png')}}" alt="Software" style="width:20px;height:20px">&nbsp;&nbsp;Software</li>
                <li class="nav-item"><a href=" {{ URL::route('software-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/add.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;New Software</a></li>
                <li class="nav-item"><a href=" {{ URL::route('software-edit-get') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Edit Software</a></li>
        <li class="nav-item"><a href=" {{ URL::route('addPortion') }}"><img src="{{asset('/includes/images/icons/options.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Options</a></li>
@else
        <li class="nav-item"><img src="{{asset('/includes/images/icons/request.png')}}" alt="Software" style="width:20px;height:20px">&nbsp;&nbsp;Requests</li>
                <li class="nav-item"><a href=" {{ URL::route('hardwarereq') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/resource.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;Resources</a></li>
                <li class="nav-item"><a href=" {{ URL::route('ftpreq') }}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{asset('/includes/images/icons/ftp.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;FTP Account</a></li>
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
    <ul class="nav navbar-nav navbar-right">
          <li><a href="#" style="color: #ffffff"></a></li>
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


<div class="collapse" id="content_left" style="float: left; width: 18%; margin-top: 50px; background-color: #ffffff; position: fixed">

  </div>




<br>
<br>
<div id="content_main">
    <div class="panel panel-default" style="width: 100%; overflow: auto;">
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
        $('div.alert').delay(4000).slideUp(300);
      </script>
    </div>
</div>

</div>
   @include('master-footer')
{{--<script src="http://listjs.com/no-cdn/list.js"></script>--}}
</body>
</html>