@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 3px;
}
</style>

<h2 style="color: #9A0000">New Software Resource</h2>

{!! Form ::open(array('url' => 'software')) !!}

<div class="well">
<div class="row">
    <div class="col-xs-4 col-md-2">
        {!!Form::label('quantity','Quantity',['style'=>'font-size:20px'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::input('number','quantity',1,['class'=>'form-control', 'min'=>'1', 'max'=>'25','onchange'=>'addRows(this.value)','style'=>'width:70px'])!!}
    </div>

</div>
</div>

<div class="span12" style="overflow:auto">

    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow">
            <th style="width: 10%">Inventory&nbsp;Code</th>
            <th style="width: 30%">Name</th>
            <th style="width: 30%">Vendor</th>
            <th style="width: 10%">No&nbsp;of&nbsp;Licenses</th>
        </tr>

            <tbody id="tableBody">
                <tr id="firstRow">
                <td>
                    <input style="width: 130px" type="text" id="inventory_code_t" name="inventory_code_t[]" class="form-control input-sm" value="{{$key}}" readonly>
                </td>

                <td>
                    {!!Form::text('name_t[]','',['class'=>'form-control input-sm'])!!}
                </td>

                <td>
                    {!!Form::text('vendor_t[]','',['class'=>'form-control input-sm'])!!}
                </td>

                <td>
                    {!!Form::input('number','no_of_license_t[]',1,['class'=>'form-control input-sm', 'min'=>'1', 'max'=>'100'])!!}
                </td>
                </tr>
            </tbody>

        </table>
</div>

<br>
<div align="right">
{!! Form::submit('Insert',['class' => 'btn btn-primary']) !!}
{{--{!! Form ::token()!!}--}}
</div>
{!! Form ::close() !!}

@endsection
@stop