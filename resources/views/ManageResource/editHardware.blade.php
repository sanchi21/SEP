
@extends('master')

@section('content')
<h2 style="color: #9A0000">Edit Software Resource</h2>

<div align="right"><label><b>Displaying 30 items per page</b></label></div>

<div class="span12" style="overflow:auto">
{!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@updateAll']]) !!}
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
    <tr id="firstRow">
        <td>
            {{$hardware->inventory_code}}
        </td>

        <td>
            {{$hardware->type}}
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
        <input type="submit" name="edit" id="edit" value="Edit" class="btn btn-primary" style="height: 30px; vertical-align: center">
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
{!! Form ::close() !!}

</div>
<div align="center">
    {!!$hardwares->render()!!}
    </div>
@endsection
@stop