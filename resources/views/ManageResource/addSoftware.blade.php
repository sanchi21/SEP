@extends('...master')

@section('content')

<h2>New Software Resource</h2>

{!! Form ::open(array('url' => 'software')) !!}

<div class="well">
<div class="row">
    <div class="col-xs-4 col-md-2">
        {!!Form::label('quantity','Quantity')!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::input('number','quantity',1,['class'=>'form-control', 'min'=>'1', 'max'=>'10','onchange'=>'addRows(this.value)'])!!}
    </div>

</div>
</div>

<div class="span12" style="overflow:auto">

    <table class="table table-hover" id="hardwareTable">
        <tr id="headRow">
            <th>Inventory&nbsp;Code</th>
            <th>Name</th>
            <th>Vendor</th>
            <th>No&nbsp;of&nbsp;Licenses</th>
        </tr>

            <tbody id="tableBody">
                <tr id="firstRow">
                <td>
                    <input type="text" id="inventory_code_t" name="inventory_code_t[]" class="rounded" value="{{$key}}" readonly>
                </td>

                <td>
                    {!!Form::text('name_t[]','',['class'=>'rounded'])!!}
                </td>

                <td>
                    {!!Form::text('vendor_t[]','',['class'=>'rounded'])!!}
                </td>

                <td>
                    {!!Form::input('number','no_of_license_t[]',1,['class'=>'form-control', 'min'=>'1', 'max'=>'100'])!!}
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