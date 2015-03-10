
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


        <select id="make" name="make">

    	    @foreach($types as $type)
    	       	<option value='{{$type->category}}'>{{ $type->category }}</option>
    	    @endforeach

        </select>

    </div>

    </div>
</div>

{{--Description--}}
<div class="row">

    <div class="col-xs-4 col-md-2">
        {!!Form::label('inventory_code','Inventory Code')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::text('inventory_code',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
            {!!Form::label('description','Description ')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::textarea('description',null,['class'=>'form-control','size'=>'20x3'])!!}
    </div>

</div><br>

{{--Serial No--}}
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('serial_no','Serial Number')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::text('serial_no',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
                    {!!Form::label('purchase_date','Purchase Date')!!}
    </div>

    <div class="col-xs-4 col-md-4">

            {!!Form::input('date','purchase_date',null,['class'=>'form-control'])!!}
    </div>
</div><br>

{{--ip address--}}
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('ip','IP Address')!!}
    </div>

    <div class="col-xs-2 col-md-1">
            <input type="text" class="form-control">
    </div>

    <div class="col-xs-2 col-md-1">
            <input type="text" class="form-control" min="0" max="255">
    </div>

    <div class="col-xs-2 col-md-1">
            <input type="text" class="form-control" min="0" max="255">
    </div>

    <div class="col-xs-2 col-md-1">
            <input type="text" class="form-control" min="0" max="255">
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::label('warranty__exp_date','Warranty Expiration')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::input('date','warranty_exp_date',null,['class'=>'form-control'])!!}
    </div>

</div><br>

{{--make--}}
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('make','Make')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::text('make',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::label('value','Value')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::text('value',null,['class'=>'form-control'])!!}
    </div>

</div><br>

{{--model--}}
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('model','Model')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::text('model',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::label('insurance','Insurance')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::text('insurance',null,['class'=>'form-control'])!!}
    </div>

</div>

@include('desktopForm')
@include('dongleSimForm')

{!! Form ::close() !!}
@endsection

@stop



{{--composer require "illuminate/html":"5.0.*"--}}