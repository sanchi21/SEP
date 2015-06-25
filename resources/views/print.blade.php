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



 {{--styles--}}

 {{--scritps--}}
 <script src="{{ asset('/includes/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrap-multiselect.js') }}"></script>
 <script src="{{ asset('/includes/js/bootstrapDatetimepicker.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/FormChange.js') }}"></script>
 <script type="text/javascript" src="{{ asset('/includes/js/validate.js') }}"></script>
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

<body>
<div>

<div name = "report-header">
        <table width="100%">
            <tr>
                <td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>
                <td width="50%"></td>
            </tr>
            <tr>
                <td width="50%"><h4>Zone24x7 (Private) Limited</h4></td>
                <td width="50%" align="right"><h4>Date : {{date("d-m-Y")}}</h4></td>
            </tr>

            <tr>
                <td width="50%"><h4>Nawala Road,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Koswatte,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Sri Lanka 10107</h4></td>
                <td></td>
            </tr>

        </table>

        <h2 align="center">{{$id}} @yield('title') </h2>

    </div>
<br>

@yield('details')

</div>

</body>
</html>