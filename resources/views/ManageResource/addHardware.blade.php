
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

         <div class="alert alert-danger" id="error_msg" style="display: none">

         <label id="msg"></label>
         </div>
<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <label style="font-size: 20px" name="category">Category</label>
        </div>


        <div class="col-xs-4 col-md-4">

            <select id="category_t" name="category_t" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
    	        @foreach($types as $type)
    	       	    <option value='/hardware/{{$type->category}}' @if($id==$type->category) selected @endif>{{ $type->category }}</option>
    	        @endforeach
            </select>

        </div>

        <div class="col-xs-4 col-md-2">
            <label style="font-size:20px" name="quantity">Quantity</label>
        </div>

        <div class="col-xs-4 col-md-2">
            <input type="number" name="quantity" value="1" class="form-control" min="1" max="25" onchange="addRows(this.value)" style="width:70px">
        </div>

    </div>
</div>

<div class="span12" style="overflow:auto; min-height: 320px">

    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">
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
            </td>

            @if($id=="Monitor")
                <td>
                    <select style="width: 80px" id="screen_size_t" name="screen_size_t[]" class="form-control input-sm">
                        @foreach($screen_size as $screen)
                            <option value='{{$screen->OS_Name}}'>{{ $screen->OS_Name }}</option>
                        @endforeach
                    </select>
                </td>
            @endif

            <td>
                <textarea name="description_t[]" class="form-control input-sm" style="width:200px;height: 30"></textarea>
            </td>

            @if($id == "Desktop" || $id == "Laptop" || $id == 'Server' || $id == 'Virtual-Server')
                <td>
                    <input type="text" name="cpu_t[]" class="form-control input-sm" style="width:80px">
                </td>

                <td>
                    <select id="ram_t" name="ram_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($ram as $rm)
                            <option value='{{$rm->Ram_Size}}'>{{ $rm->Ram_Size }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select id="hard_disk_t" name="hard_disk_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($hard_disk as $hard)
                            <option value='{{$hard->Disk_Size}}'>{{ $hard->Disk_Size }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select id="os_t" name="os_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($os as $operating)
                            <option value='{{$operating->OS_Name}}'>{{ $operating->OS_Name }}</option>
                        @endforeach
                    </select>
                </td>

                @if($id == "Server")
                    <td>
                        <input type="text" name="server_classification_t[]" class="form-control input-sm" style="width:160px">
                    </td>
                    <td>
                        <input type="number" name="no_of_cpu_t[]" value="1" class="form-control input-sm" min="1">
                    </td>
                @elseif($id == "Virtual-Server")
                    <td>
                        <input type="text" name="host_server_t[]" class="form-control input-sm" style="width:130px">
                    </td>
                    <td>
                        <input type="number" name="no_of_core_t[]" value="1" class="form-control input-sm" min="1" style="width:70px">
                    </td>
                @endif
            @endif

            @if($id == 'Client-Device')
                <td>
                    <input type="text" name="device_type_t[]" class="form-control input-sm" style="width:130px">
                </td>
                <td>
                    <input type="text" name="client_name_t[]" class="form-control input-sm" style="width:130px">
                </td>

            @endif

            @if($id == 'Dongle')
                <td>
                    <input type="text" name="phone_number_t[]" class="form-control input-sm" style="width:120px">
                </td>
                <td>
                    <select id="service_provider_t" name="service_provider_t[]" class="form-control input-sm" style="width: 130px">
                        @foreach($service_provider as $service)
                            <option value='{{$service->Provider_Name}}'>{{ $service->Provider_Name }}</option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <input type="text" name="data_limit_t[]" class="form-control input-sm" style="width:70px">
                </td>
                <td>
                    <input type="text" name="monthly_rental_t[]" class="form-control input-sm" style="width:120px">
                </td>
            @endif

            @if($id == 'Sim')
                <td>
                    <input type="text" name="phone_number_t[]" class="form-control input-sm" style="width:120px">
                </td>
                <td>
                    <input type="text" name="service_provider_t[]" class="form-control input-sm" style="width:130px">
                </td>

                <td>
                    <input type="text" name="location_t[]" class="form-control input-sm" style="width:130px">
                </td>
            @endif

            <td>
                <input type="text" name="serial_no_t[]" class="form-control input-sm" style="width:130px">
            </td>

            <td>
                <input type="text" name="ip_address_t[]" class="form-control input-sm" style="width:140px">
            </td>

            <td>
                <select id="make_t" name="make_t[]" class="form-control input-sm" style="width: 140px">
                    @foreach($make as $mk)
                        <option value='{{$mk->Make_Name}}'>{{ $mk->Make_Name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="text" name="model_t[]" class="form-control input-sm" style="width:120px">
            </td>

            <td>
                <input type="date" name="purchase_date_t[]" class="form-control input-sm" placeholder="mm/dd/yyyy" style="width:135px">
            </td>

            <td>
                <input type="date" name="warranty_exp_t[]" class="form-control input-sm" placeholder="mm/dd/yyyy" style="width:135px">
            </td>

            <td>
                <input type="text" name="insurance_t[]" class="form-control input-sm" style="width:80px">
            </td>

            <td>
                <input type="text" name="value_t[]" class="form-control input-sm" style="width:80px">
            </td>
        </tr>

        </tbody>
    </table>


</div>
<br>
<div align="right">
{!! Form::submit('Insert',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validation()']) !!}
{{--{!! Form ::token()!!}--}}
</div>
<br>
{!! Form ::close() !!}

@endsection
@stop

{{--composer require "illuminate/html":"5.0.*"--}}