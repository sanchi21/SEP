
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 3px;
}
</style>




<h2 style="color: #9A0000">New Hardware Resource</h2>
<br>

{!! Form ::open(array('url' => 'hardware')) !!}


<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            {!!Form::label('category','Category ',['style'=>'font-size:20px'])!!}
        </div>
        <div class="col-xs-4 col-md-4">

            <select id="category" name="category_t" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
    	        @foreach($types as $type)
    	       	    <option value='/hardware/{{$type->category}}' @if($id==$type->category) selected @endif>{{ $type->category }}</option>
    	        @endforeach
            </select>

        </div>

        <div class="col-xs-4 col-md-2">
                {!!Form::label('quantity','Quantity',['style'=>'font-size:20px'])!!}
        </div>

        <div class="col-xs-4 col-md-2">
                    {!!Form::input('number','quantity',1,['class'=>'form-control', 'min'=>'1', 'max'=>'25','onchange'=>'addRows(this.value)','style'=>'width:70px'])!!}
    </div>

    </div>
</div>

<div class="span12" style="overflow:auto">

{{--@if($id == 'Office-Equipment' || $id == 'Communication-Equipment' || $id == 'Network-Equipment' || $id == 'Development-Device' || $id == 'Power-Equipment')--}}
    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow">
            <th>Inventory&nbsp;Code</th>
            @if($id == 'Monitor')
                <th>Screen&nbsp;Size</th>
            @endif

            <th>Description</th>

            @if($id == 'Desktop' || $id== 'Laptop' || $id == 'Server' || $id == 'Virtual-Server')
                <th>CPU</th>
                <th>RAM</th>
                <th>Hard&nbsp;Disk</th>
                <th>OS</th>

                @if($id == "Server")
                    <th>Server&nbsp;Classification</th>
                    <th>No&nbsp;of&nbsp;CPU</th>
                @elseif($id == "Virtual-Server")
                    <th>Host&nbsp;Server</th>
                    <th>No&nbsp;of&nbsp;Cores</th>
                @endif
            @endif

            @if($id == "Client-Device")
                <th>Device&nbsp;Type</th>
                <th>Client&nbsp;Name</th>
            @endif

            @if($id == "Dongle")
                <th>Phone&nbsp;Number</th>
                <th>Service&nbsp;Provider</th>
                <th>Data&nbsp;Limit</th>
                <th>Monthly&nbsp;Rental</th>
            @endif

            @if($id == "Sim")
                <th>Phone&nbsp;Number</th>
                <th>Service&nbsp;Provider</th>
                <th>Location</th>
            @endif

            <th>Serial&nbsp;No</th>
            <th>IP&nbsp;Address&nbsp;</th>
            <th>Make&nbsp;</th>
            <th>Model</th>
            <th>Purchase&nbsp;Date</th>
            <th>Warranty&nbsp;Exp</th>
            <th>Insurance</th>
            <th>Value</th>
        </tr>
        <tbody id="tableBody">
        <tr id="firstRow">
            <td>
                <input style="width: 130px" type="text" id="inventory_code_t" name="inventory_code_t[]" class="form-control input-sm" value="{{$key}}" readonly>
                {{--{!!Form::text('inventory_code_t','$id',['class'=>'rounded','readonly'])!!}--}}
            </td>

            @if($id=="Monitor")
                <td>
                    <select style="width: 80px" id="screen_size_t" name="screen_size_t[]" class="form-control input-sm">
                        @foreach($types as $type)
                            <option value='{{$type->category}}'>{{ $type->category }}</option>
                        @endforeach
                    </select>
                </td>
            @endif

            <td>
            {!!Form::textarea('description_t[]','',['class'=>'form-control input-sm','size'=>'30x1','style'=>'width:200px','style'=>'height: 30'])!!}
            </td>

            @if($id == "Desktop" || $id == "Laptop" || $id == 'Server' || $id == 'Virtual-Server')
                <td>
                    <select id="cpu_t" name="cpu_t[]" class="form-control input-sm" style="width: 100px">
                        @foreach($types as $type)
                            <option value='{{$type->category}}'>{{ $type->category }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select id="ram_t" name="ram_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($types as $type)
                            <option value='{{$type->category}}'>{{ $type->category }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select id="hard_disk_t" name="hard_disk_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($types as $type)
                            <option value='{{$type->category}}'>{{ $type->category }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select id="os_t" name="os_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($types as $type)
                            <option value='{{$type->category}}'>{{ $type->category }}</option>
                        @endforeach
                    </select>
                </td>

                @if($id == "Server")
                    <td>
                        {!!Form::text('server_classification_t[]','',['class'=>'form-control input-sm','style'=>'width:160px'])!!}
                    </td>
                    <td>
                        {!!Form::input('number','no_of_cpu_t[]',1,['class'=>'form-control input-sm', 'min'=>'1', 'max'=>'10'])!!}
                    </td>
                @elseif($id == "Virtual-Server")
                    <td>
                        {!!Form::text('host_server_t[]','',['class'=>'form-control input-sm','style'=>'width:130px'])!!}
                    </td>
                    <td>
                        {!!Form::input('number','no_of_core_t[]',1,['class'=>'form-control input-sm', 'min'=>'1', 'max'=>'10','style'=>'width:70px'])!!}
                    </td>
                @endif
            @endif

            @if($id == 'Client-Device')
                <td>
                {!!Form::text('device_type_t[]','',['class'=>'form-control input-sm','style'=>'width:130px'])!!}
                </td>
                <td>
                {!!Form::text('client_name_t[]','',['class'=>'form-control input-sm','style'=>'width:130px'])!!}
                </td>

            @endif

            @if($id == 'Dongle')
                <td>
                {!!Form::text('phone_number_t[]','',['class'=>'form-control input-sm','style'=>'width:120px'])!!}
                </td>
                <td>
                {!!Form::text('service_provider_t[]','',['class'=>'form-control input-sm','style'=>'width:120px'])!!}
                </td>

                <td>
                {!!Form::text('data_limit_t[]','',['class'=>'form-control input-sm','style'=>'width:70px'])!!}
                </td>
                <td>
                {!!Form::text('monthly_rental_t[]','',['class'=>'form-control input-sm','style'=>'width:120px'])!!}
                </td>
            @endif

            @if($id == 'Sim')
                <td>
                {!!Form::text('phone_number_t[]','',['class'=>'form-control input-sm','style'=>'width:120px'])!!}
                </td>
                <td>
                {!!Form::text('service_provider_t[]','',['class'=>'form-control input-sm','style'=>'width:130px'])!!}
                </td>

                <td>
                {!!Form::text('location_t[]','',['class'=>'form-control input-sm','style'=>'width:130px'])!!}
                </td>
            @endif

            <td>
            {!!Form::text('serial_no_t[]','',['class'=>'form-control input-sm','style'=>'width:130px','id'=>'serial_no_t'])!!}
            </td>

            <td>
            {!!Form::text('ip_address_t[]','',['class'=>'form-control input-sm','style'=> 'width:140px'])!!}
            </td>

            <td>
            <select id="make_t" name="make_t[]" class="form-control input-sm" style="width: 140px">
                	        @foreach($types as $type)
                	       	    <option value='{{$type->category}}'>{{ $type->category }}</option>
                	        @endforeach
            </select>
            </td>

            <td>
            {!!Form::text('model_t[]','',['class'=>'form-control input-sm','style'=> 'width:120px'])!!}
            </td>

            <td>
            {!!Form::input('date','purchase_date_t[]',null,['class'=>'form-control input-sm','placeholder'=>'mm/dd/yyyy','style'=> 'width:135px','id'=>'purchase_date_t'])!!}
            </td>

            <td>
            {!!Form::input('date','warranty_exp_t[]',null,['class'=>'form-control input-sm','placeholder'=>'mm/dd/yyyy','style'=> 'width:135px'])!!}
            </td>

            <td>
            {!!Form::text('insurance_t[]','',['class'=>'form-control input-sm','style'=> 'width:80px'])!!}
            </td>

            <td>
            {!!Form::text('value_t[]','',['class'=>'form-control input-sm','style'=> 'width:80px'])!!}
            </td>
        </tr>

        </tbody>
    </table>
  {{--@elseif($id == 'Monitor')--}}
  {{--@include('monitorTable',['screen_size'=>$id])--}}
{{--@endif--}}

</div>
<br>
<div align="right">
{!! Form::submit('Insert',['class' => 'btn btn-primary']) !!}
{{--{!! Form ::token()!!}--}}
</div>
<br>
{!! Form ::close() !!}

@endsection
@stop

{{--composer require "illuminate/html":"5.0.*"--}}