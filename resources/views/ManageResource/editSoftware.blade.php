

@extends('master')

@section('content')
<style>
.table
{
margin-bottom: 0px;
}
</style>

<h2 style="color: #9A0000">Edit Software Resource</h2>
<br>

@if($errors->any())
         <div class="alert alert-danger" id="error_msg">
            <ul style="list-style: none">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
         </div>
         @endif

<div class="well">
{!! Form ::open(['method' => 'POST', 'url' => 'software-edit/search']) !!}
<table>
    <tr>
        <td>
            <input type="text" name="search_t" class="form-control input-sm" style="width: 200px" placeholder="Search">{{--<label style="width: 100px">Search</label>--}}
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary form-control" style="height: 30px;"><span class="glyphicon glyphicon-search"></span> </button>
        </td>
        <td>
            &nbsp;&nbsp;&nbsp;
        </td>

        <td>&nbsp;&nbsp;&nbsp;
            <label style="width: 120px">Sort by</label>
        </td>
        <td>
            <select id="sort" name="sort_t" class="form-control input-sm" style="width: 250px">
                <option value="inventory_code" @if($column=='inventory_code') selected @endif>Inventory Code</option>
                <option value="name" @if($column=='name') selected @endif>Name</option>
                <option value="vendor" @if($column=='vendor') selected @endif>Vendor</option>
                <option value="no_of_license" @if($column=='no_of_license') selected @endif>No of License</option>
            </select>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary form-control" style="height: 30px;" name="ascend" value="ascend"><span class="glyphicon glyphicon-chevron-up"></span> </button>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary form-control" style="height: 30px;" name="descend" value="descend"><span class="glyphicon glyphicon-chevron-down"></span> </button>
        </td>

        <td>
            &nbsp;<input type="button" onclick="printContent('content12')" class="btn btn-primary" style="height: 30px; width: 70px" value="Print">
        </td>
</tr>
</table>
{!! Form ::close() !!}
</div>
<br>


<div align="right"><label><b>Displaying 10 items per page</b></label></div>


<div class="panel-body">
    <table class="table table-hover" width="100%">
            <tr style="background-color: #e7e7e7">
                <td width="10%">
                    <label style="color: #9A0000">Inventory&nbsp;Code</label>
                </td>

                <td width="30%">
                    <label>Name</label>
                </td>

                <td width="30%">
                    <label>Vendor</label>
                </td>

                <td width="10%">
                    <label>No&nbsp;of&nbsp;License</label>
                </td>

                <td width="20%"></td>

            </tr>
            </table>
@foreach($softwares as $software)
{!! Form ::open(['method' => 'POST', 'action' => ['SoftwareController@update']]) !!}

    <table class="table table-hover" id="hardwareTable" width="100%" cellpadding="1px" cellspacing="1px">
        <tbody id="tableBody">
        <tr>
            <td width="10%">
                <label>{{$software->inventory_code}}</label><input type="hidden" name="inventory_code_t" value="{{$software->inventory_code}}">
            </td>

            <td width="30%">
            <input type="text" name="name_t" class="form-control input-sm" value="{{$software->name}}" size="50px">
            </td>

            <td width="30%">
            <input type="text" name="vendor_t" class="form-control input-sm" value="{{$software->vendor}}" size="50px">
            </td>

            <td width="10%">
                <input type="number" name="no_of_license_t" class="form-control input-sm" value="{{$software->no_of_license}}" min="1"  size="50px">
            </td>

            <td width="20%">
            <input type="submit" name="delete" class="btn btn-danger form-control" value="Delete&nbsp;" style="width: 80px">&nbsp;&nbsp;
            <input type="submit" name="update" class="btn btn-primary form-control" value="Update">
            </td>
        </tr>

        </tbody>
    </table>

{!! Form ::close() !!}

@endforeach
</div>
<div align="center">
{!!$softwares->render()!!}
</div>



<div id="content12" name="content12" style="display: none">

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

        <h2 align="center">Software Details</h2>

    </div>

    <table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">

    <tr style="background-color: #e7e7e7">
        <th>Inventory&nbsp;Code</th>
        <th>Name</th>
        <th>Vendor</th>
        <th>No&nbsp;of&nbsp;Licenses</th>
    </tr>
    <tbody id="tableBody">
        @foreach($softwares as $software)
            <tr>
                <td><h5>{{$software->inventory_code}}</h5></td>
                <td><h5>{{$software->name}}</h5></td>
                <td><h5>{{$software->vendor}}</h5></td>
                <td><h5>{{$software->no_of_license}}</h5></td>
            </tr>
        @endforeach
    </tbody>
    </table>
<br>

</div>

@endsection
@stop

<script>
    function printContent(print_content){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(print_content).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>