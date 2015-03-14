
@extends('master')

@section('content')
<br xmlns="http://www.w3.org/1999/html">
<br>
<h2>New Hardware Resource</h2>

{!! Form ::open() !!}

<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            {!!Form::label('category','Category ')!!}
        </div>
        <div class="col-xs-4 col-md-4">

            <select id="make" name="make" class="form-control" onchange="javascript:location.href = this.value;">
    	        @foreach($types as $type)
    	       	    <option value='/resource/{{$type->category}}' @if($id==$type->category) selected @endif>{{ $type->category }}</option>
    	        @endforeach
            </select>

        </div>


        <div class="col-xs-4 col-md-2">
                {!!Form::label('quantity','Quantity')!!}
        </div>

        <div class="col-xs-4 col-md-2">
                    {!!Form::input('number','nm',1,['class'=>'form-control', 'min'=>'1', 'max'=>'10','onchange'=>'addRows(this.value)'])!!}
    </div>

    </div>
</div>

<div class="span12" style="overflow:auto">

@if($id == 'Office-Equipment' || $id == 'Communication-Equipment' || $id == 'Network-Equipment' || $id == 'Development-Device' || $id == 'Power-Equipment')
    <table class="table table-hover" id="hardwareTable">
        <tr id="headRow">
            <th>Inventory&nbsp;Code</th>
            <th width>Description</th>
            <th>Serial&nbsp;No</th>
            <th>IP&nbsp;Address&nbsp;</th>
            <th>Make&nbsp;</th>
            <th>Model</th>
            <th>Purchase&nbsp;Date</th>
            <th>Warranty&nbsp;Expiration</th>
            <th>Insurance</th>
            <th>Value</th>
        </tr>
        <tbody id="tableBody">
        <tr id="firstRow">
            <td>
                <input type="inventory_code_t[1]" class="rounded" value="{{$key}}" readonly>
                {{--{!!Form::text('inventory_code_t','$id',['class'=>'rounded','readonly'])!!}--}}
            </td>

            <td>
            {!!Form::textarea('description_t[1]','',['class'=>'rounded','size'=>'50x1'])!!}
            </td>

            <td>
            {!!Form::text('serial_no_t[1]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('ip_address_t[1]','',['class'=>'rounded'])!!}
            </td>

            <td>
            <select id="make" name="make" class="rounded">
                	        @foreach($types as $type)
                	       	    <option value='{{$type->category}}'>{{ $type->category }}</option>
                	        @endforeach
            </select>
            </td>

            <td>
            {!!Form::text('model_t[1]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::input('date','purchase_date_t[1]',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::input('date','warranty_exp_t[1]',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::text('insurance_t[1]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('value_t[1]','',['class'=>'rounded'])!!}
            </td>
        </tr>

        </tbody>
    </table>
  @elseif($id == 'Monitor')
  @include('monitorTable')
@endif

</div>

{!! Form ::close() !!}
@endsection
@stop

{{--composer require "illuminate/html":"5.0.*"--}}