<html>
<head>
    <title>Zone 24x7 - Resource Allocation System</title>

{{--styles--}}
 <link href="{{ asset('/includes/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/custom-login.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/bootstrap-multiselect.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/bootstrapDatetimepicker.min.css') }}" rel="stylesheet">
 <link href="{{ asset('/includes/css/resource.css') }}" rel="stylesheet">

 <link href="{{ asset('/includes/css/bootstrap-combined.min.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('/includes/js/jquery-alert-dialogs/css/jquery.alerts.css') }}" type="text/css" rel="stylesheet" media="screen">--}}


 {{--styles--}}

 {{--scritps--}}
 <script src="{{ asset('/includes/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap-multiselect.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrapDatetimepicker.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/FormChange.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/validate.js') }}"></script>

 {{--<script type="text/javascript" src="{{ asset('/includes/js/jquery-alert-dialogs/js/jquery.js') }}"></script>--}}
 {{--<script type="text/javascript" src="{{ asset('/includes/js/jquery-alert-dialogs/js/jquery.ui.draggable.js') }}"></script>--}}
 {{--<script type="text/javascript" src="{{ asset('/includes/js/jquery-alert-dialogs/js/jquery.alerts.js') }}"></script>--}}

 {{--scritps--}}

<style>
.well
{
    background-color: #ffffff;
    padding: 12px;
}
</style>




    {{--<link href="http://localhost:8080/includes/css/bootstrap.min.css" rel="stylesheet">--}}




</head>
<body style="background-color: rgba(229, 228, 226, 0.5); height:100%; width: 97% " onload="d()">
{{--f1f1f1--}}
<ul class="navigation">
@if(Auth::User()->username!="srinithy")
        {{--<li class="nav-item"><img src="{{asset('/includes/images/icons/hardware.png')}}" alt="Hardware" style="width:20px;height:20px">&nbsp;&nbsp;Hardware</li>--}}


        <ul class="list">
            <li>
            <a style="padding: 0px;height: auto; text-decoration: none; cursor: pointer" class="nav-item"  data-toggle="tooltip" title="INVENTORY MANAGEMENT"><img src="{{asset('/includes/images/icons/inventory_management.png')}}" alt="Options"></a>
                <ul>
                    <li class="nav-item" id="hardware"><a id="hardware_a" href=" {{ URL::route('hardware') }}"><img src="{{asset('/includes/images/icons/add.png')}}" alt="New Hardware" style="width:18px;height:18px">&nbsp;&nbsp;New Resource</a></li>
                    <li class="nav-item" id="hardware-edit/All"><a id="hardware-edit/All_a" href=" {{ URL::route('hardware-edit-get') }}"><img src="{{asset('/includes/images/icons/edit.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;View Resource</a></li>
                    <li class="nav-item" id="HardwareMaintenance"><a id="HardwareMaintenance_a" href=" {{ URL::route('HardwareMaintenance') }}"><img src="{{asset('/includes/images/icons/options.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Maintenance</a></li>
                    <li class="nav-item" id="MonthlyExpenses"><a id="MonthlyExpenses_a" href=" {{ URL::route('ViewMonthlyExpenses') }}"><img src="{{asset('/includes/images/icons/expenditure.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Expenditure</a></li>
                </ul>
            </li>

            <li>
            {{--<a style="text-align: center;background-color: maroon; color: #ffffff;height: auto; text-decoration: none; cursor: pointer" class="nav-item" data-toggle="tooltip" title="RESOURCE ALLOCATION">RESOURCE ALLOCATION</a>--}}
            <a style="padding: 0px;height: auto; text-decoration: none; cursor: pointer" class="nav-item"  data-toggle="tooltip" title="RESOURCE ALLOCATION"><img src="{{asset('/includes/images/icons/resource_allocation.png')}}" alt="Options"></a>
                <ul>
                    <li class="nav-item" id="Allocate"><a id="Allocate_a" href=" {{ URL::route('ViewRequests') }}"><img src="{{asset('/includes/images/icons/allocate.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Allocate&nbsp;PR</a></li>
                    <li class="nav-item" id="AssignFolder"><a id="AssignFolder_a" href=" {{ URL::route('ViewFolderRequests') }}"><img src="{{asset('/includes/images/icons/assign_folder.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Assign Folder</a></li>
                    <li class="nav-item" id="other-request-update"><a id="other-request-update_a" href=" {{ URL::route('other-request-update') }}"><img src="{{asset('/includes/images/icons/other_request.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Other Requests</a></li>
                    <li class="nav-item" id="renewalAccept" ><a id="renewalAccept_a" href=" {{ URL::route('renewalAccept') }}"><img src="{{asset('/includes/images/icons/renew.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Renewal Resources</a></li>
                    <li class="nav-item" id="releaseResource"><a id="releaseResource_a" href=" {{ URL::route('releaseResource') }}"><img src="{{asset('/includes/images/icons/release.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Release&nbsp;Resources</a></li>
                    <li class="nav-item" id="employeeAllocation"><a id="employeeAllocation_a" href=" {{ URL::route('employeeAllocation') }}"><img src="{{asset('/includes/images/icons/allocate_i.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;User&nbsp;Allocation</a></li>
                </ul>
            </li>

            <li>
            <a style="padding: 0px;height: auto; text-decoration: none; cursor: pointer" class="nav-item"  data-toggle="tooltip" title="PROCUREMENT"><img src="{{asset('/includes/images/icons/procurement.png')}}" alt="Options"></a>
                <ul>
                    <li class="nav-item" id="viewInvoice"><a id="viewInvoice_a" href=" {{ URL::route('ViewInvoice') }}"><img src="{{asset('/includes/images/icons/view_invoice.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;View Invoices</a></li>
                    <li class="nav-item" id="placeOrder"><a id="placeOrder_a" href=" {{ URL::route('placeOrder') }}"><img src="{{asset('/includes/images/icons/order.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Place Order</a></li>
                    <li class="nav-item" id="purchase-request"><a id="purchase-request_a" href=" {{ URL::route('purchase-request') }}"><img src="{{asset('/includes/images/icons/purchase_request.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Purchase Request</a></li>
                     <li class="nav-item" id="Approval"><a id="Approval_a" href=" {{ URL::route('ViewRequestsApp') }}"><img src="{{asset('/includes/images/icons/approve_procurement.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Purchase Approval</a></li>

                </ul>
            </li>

            <li>
            <a style="padding: 0px;height: auto; text-decoration: none; cursor: pointer" class="nav-item"  data-toggle="tooltip" title="ADMINISTRATOR"><img src="{{asset('/includes/images/icons/administrator.png')}}" alt="Options"></a>
                <ul>
                    {{--<li class="nav-item" id="home"><a id="home_a" href=" {{ URL::route('home-admin-full') }}"><img src="{{asset('/includes/images/icons/70370.png')}}" alt="Home" style="width:20px;height:20px">&nbsp;&nbsp;Home</a></li>--}}
                    <li class="nav-item" id="addUser"><a id="addUser_a" href=" {{ URL::route('add-user') }}"><img src="{{asset('/includes/images/icons/user.png')}}" alt="Manage Users" style="width:20px;height:20px">&nbsp;&nbsp;Manage Users</a></li>
                    <li class="nav-item" id="change-property/New"><a id="change-property/New_a" href=" {{ URL::route('change-property/New') }}"><img src="{{asset('/includes/images/icons/add_attr.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Manage&nbsp;Attributes</a></li>
                    <li class="nav-item" id="change-options"><a id="change-options_a" href=" {{ URL::route('change-options') }}"><img src="{{asset('/includes/images/icons/drop_down.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Edit Drop DownList</a></li>
                    <li class="nav-item" id="request-type/New"><a id="request-type/New_a" href=" {{ URL::route('request-type/New') }}"><img src="{{asset('/includes/images/icons/create_request.png')}}" alt="Edit Hardware" style="width:18px;height:18px">&nbsp;&nbsp;Request Type</a></li>
                </ul>
            </li>

            <li>
            <a style="padding: 0px;height: auto; text-decoration: none; cursor: pointer" class="nav-item"  data-toggle="tooltip" title="REPORTS"><img src="{{asset('/includes/images/icons/reports.png')}}" alt="Options"></a>
                <ul>
                    <li class="nav-item" id="requestVendorReports" ><a id="requestVendorReports_a" href=" {{ URL::route('requestVendorReports') }}"><img src="{{asset('/includes/images/icons/edit_sw.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Request&nbsp;Reports</a></li>
                    <li class="nav-item" id="requestReleaseAdmin" ><a id="requestReleaseAdmin_a" href=" {{ URL::route('requestReleaseAdmin') }}"><img src="{{asset('/includes/images/icons/edit_sw.png')}}" alt="Options" style="width:20px;height:20px">&nbsp;&nbsp;Release&nbsp;Request</a></li>
                </ul>
            </li>

        </ul>



@else

        {{--<li class="nav-item"><img src="{{asset('/includes/images/icons/request.png')}}" alt="Software" style="width:20px;height:20px">&nbsp;&nbsp;Requests</li>--}}
                <li class="nav-item" id="hardwarereq"><a id="hardwarereq_a" href=" {{ URL::route('hardwarereq') }}"><img src="{{asset('/includes/images/icons/resource.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;Resources</a></li>
                <li class="nav-item" id="ftpreq"><a id="ftpreq_a" href=" {{ URL::route('ftpreq') }}"><img src="{{asset('/includes/images/icons/ftp.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;FTP Account</a></li>
                <li class="nav-item" id="Connectivity"><a id="Connectivity_a" href=" {{ URL::route('Connectivity') }}"><img src="{{asset('/includes/images/icons/connect.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Connectivity</a></li>
                <li class="nav-item" id="Other Requests"><a id="Other Requests_a" href=" {{ URL::route('other-request') }}"><img src="{{asset('/includes/images/icons/other_request.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Other Request</a></li>

                {{--<li class="nav-item" id="requestRelease"><a id="requestRelease_a" href=" {{ URL::route('requestRelease') }}"><img src="{{asset('/includes/images/icons/resource.png')}}" alt="New Software" style="width:18px;height:18px">&nbsp;&nbsp;Request Release</a></li>--}}
                <li class="nav-item" id="renewal"><a id="renewal_a" href=" {{ URL::route('renewal') }}"><img src="{{asset('/includes/images/icons/renew.png')}}" alt="Edit Software" style="width:18px;height:18px">&nbsp;&nbsp;Renew&nbsp;Project</a></li>
   @endif

    {{--<li class="nav-item"></li>--}}
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

    <li>
        <a href="{{ URL::route('home-admin-full') }}" style="color: #ffffff;font-size: 20px"><span class="glyphicon glyphicon-home"></span></a>
    </li>
    <li>
        <a href="{{ URL::route('sign-out') }}" style="color: #ffffff;font-size: 20px"><span class="glyphicon glyphicon-log-out"></span></a>
    </li>
    <li>
        <a href="#" style="color: #ffffff;font-size: 16px"> {{Auth::User()->username }}</a>
    </li>

          </ul>
  </div>
</nav>


<div class="collapse" id="content_left" style="float: left; width: 18%; margin-top: 50px; background-color: #ffffff; position: fixed">

  </div>




<br>
<br>
<div id="content_main">
    <div class="panel panel-default" style="width: 100%; overflow: auto;margin-bottom: 0px">
      <div class="panel-body">
        @if(Session::has('flash_message'))
        <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('flash_message')}}
        </div>
        @elseif(Session::has('flash_message_error'))
                <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('flash_message_error')}}
                </div>
        @endif


       @yield('content')
      </div>
      {{--<script>--}}
        {{--$('div.alert').delay(10000).slideUp(300);--}}
      {{--</script>--}}

      {{--<script>--}}
        {{--$('div.alert-danger').delay(10000).slideUp(300);--}}
      {{--</script>--}}

      <script>
      $('.list > li a').click(function() {
          $(this).parent().find('ul').toggle();
      });
      </script>

    </div>
</div>

</div>
   @include('master-footer')
{{--<script src="http://listjs.com/no-cdn/list.js"></script>--}}
</body>
</html>

<script>
function d()
{
    var g = window.location.pathname;
    var gg = g.replace('/','');
    document.getElementById(gg).style.backgroundColor = 'rgba(0, 155, 179, 0.9)';
    document.getElementById(gg.concat('_a')).style.color = 'white';
}
</script>
