
@extends('master')

@section('content')
<h2 style="color: #9A0000">Hardware Resource</h2>
<br>

<div class="well">
{!! Form ::open() !!}
<table>
<tr>
    <td>
       <input type="text" name="search_t" class="form-control input-sm" style="width: 200px" placeholder="Search">{{--<label style="width: 100px">Search</label>--}}
    </td>
    <td>
        &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;"><span class="glyphicon glyphicon-search"></span> </button>
    </td>
    <td>
    &nbsp;&nbsp;&nbsp;
    </td>
    <td>
        <label style="width: 120px">Category</label>
    </td>
    <td>
        <select id="category" name="category_t" class="form-control input-sm" style="width: 250px" onchange="javascript:location.href = this.value;">
            <option value="/hardware-edit/All" @if($id=="All") selected @endif>All</option>
            @foreach($types as $type)
                <option value='/hardware-edit/{{$type->category}}' @if($id==$type->category) selected @endif>{{ $type->category }}</option>
            @endforeach
        </select>
    </td>

        <td>&nbsp;&nbsp;&nbsp;
            <label style="width: 120px">Sort by</label>
        </td>
        <td>
            <select id="sort" name="sort_t" class="form-control input-sm" style="width: 250px">
                <option value="inventory_code" @if($column=='inventory_code') selected @endif>Inventory Code</option>
                <option value="make" @if($column=='make') selected @endif>Make</option>
                <option value="value" @if($column=='value') selected @endif>Value</option>
                <option value="insurance" @if($column=='insurance') selected @endif>Insurance</option>
                <option value="warranty_exp" @if($column=='warranty_exp') selected @endif>Warranty</option>
                <option value="ip_address" @if($column=='ip_address') selected @endif>IP Address</option>

            </select>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;" name="ascend" value="ascend"><span class="glyphicon glyphicon-chevron-up"></span> </button>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;" name="descend" value="descend"><span class="glyphicon glyphicon-chevron-down"></span> </button>
        </td>
</tr>
</table>
{!! Form ::close() !!}
</div>
<br>
<div align="right"><label><b>Displaying 30 items per page</b></label></div>

<div class="span12" style="overflow:auto">

<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
    <tr id="headRow">
        <th>Inventory&nbsp;Code</th>
        <th>Category</th>
        <th>Description</th>
        <th>Serial&nbsp;No</th>
        <th>IP&nbsp;Address&nbsp;</th>
        <th>Make&nbsp;</th>
        <th>Model</th>
        <th>Purchase&nbsp;Date</th>
        <th>Warranty&nbsp;Exp</th>
        <th>Insurance</th>
        <th >Value</th>
        <th></th>
    </tr>

    <tbody id="tableBody">

    @foreach($hardwares as $hardware)
    {!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@editSpecific']]) !!}
    <tr>
        <td>
            {{$hardware->inventory_code}}<input type="hidden" name="inventory_code_t" value="{{$hardware->inventory_code}}">
        </td>

        <td>
            {{$hardware->type}} <input type="hidden" name="type_t" value="{{$hardware->type}}">
        </td>
        <td>
            {{$hardware->description}}
        </td>

        <td>
            {{$hardware->serial_no}}
        </td>

        <td>
            {{$hardware->ip_address}}
        </td>

        <td>
            {{$hardware->make}}
        </td>

        <td>
            {{$hardware->model}}
        </td>

        <td>
            {{$hardware->purchase_date}}
        </td>

        <td>
            {{$hardware->warranty_exp}}
        </td>

        <td>
            {{$hardware->insurance}}
        </td>

        <td>
            {{$hardware->value}}
        </td>

        <td>
        <input type="submit" name="edit" value="Edit" class="btn btn-primary" style="height: 30px; vertical-align: center">
        </td>
    </tr>
    {!! Form ::close() !!}
    @endforeach

    </tbody>
</table>


</div>
<div align="center">
    {!!$hardwares->render()!!}
    </div>
@endsection
@stop