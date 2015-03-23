

@extends('master')

@section('content')

<h2 style="color: #9A0000">Edit Software Resource</h2>

{!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@update']]) !!}
<div class="alert alert-danger" id="error_msg" style="display: none">

         <label id="msg"></label>
         </div>

<br>
<div class="panel-body">
<h3>{{$type}}</h3><input type="hidden" name="type_t" id="type_t" value="{{$type}}">
<br>
    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">
        <tr>
            <td>
                <label style="color: #9A0000">Inventory&nbsp;Code</label>
            </td>

            <td>
                {{$hardware->inventory_code}}<input type="hidden" name="inventory_code_t" value="{{$hardware->inventory_code}}">
            </td>

            <td>
                Description
            </td>

            <td>
                <input type="textarea" name="description_t" class="form-control input-sm" value="{{$hardware->description}}" style="width: 250px">
            </td>

        </tr>

        <tr>
            <td>
                Serial&nbsp;No
            </td>

            <td>
            <input type="text" name="serial_no_t" class="form-control input-sm" value="{{$hardware->serial_no}}" style="width: 250px">
            </td>

            <td>
                IP&nbsp;Address
            </td>

            <td>
                <input type="text" name="ip_address_t" id="ip_address_t" class="form-control input-sm" value="{{$hardware->ip_address}}" style="width: 250px">
            </td>
        </tr>

        <tr>
            <td>
                Make
            </td>

            <td>
                <select id="make_t" name="make_t" class="form-control input-sm" style="width: 140px">
                    @foreach($make as $mk)
                        <option value='{{$mk->Make_Name}}' @if($hardware->make == $mk->Make_Name) selected @endif>{{ $mk->Make_Name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                Model
            </td>

            <td>
                <input type="text" name="model_t" class="form-control input-sm" value="{{$hardware->model}}" style="width: 250px">
            </td>
        </tr>

        <tr>
            <td>
                Purchase&nbsp;Date
            </td>

            <td>
                <input type="date" name="purchase_date_t" id="purchase_date_t" class="form-control input-sm" value="{{$hardware->purchase_date}}" style="width: 250px">
            </td>

            <td>
                Warranty&nbsp;Exp
            </td>

            <td>
                <input type="date" name="warranty_exp_t" id="warranty_exp_t" class="form-control input-sm" value="{{$hardware->warranty_exp}}" style="width: 250px">
            </td>
        </tr>

        <tr>
            <td>
                Insurance
            </td>

            <td>
                <input type="text" name="insurance_t" id="insurance_t" class="form-control input-sm" value="{{$hardware->insurance}}" style="width: 250px">
            </td>

            <td>
                Value
            </td>

            <td>
                <input type="text" name="value_t" id="value_t" class="form-control input-sm" value="{{$hardware->value}}" style="width: 250px">
            </td>
        </tr>

        @if($monitor != '')
        <tr>
            <td>
                Screen&nbsp;Size
            </td>

            <td>
            <input type="text" name="screen_size_t" class="form-control input-sm" value="{{$monitor->screen_size}}" style="width: 250px">
            </td>
        </tr>
        @endif

        @if($laptop != '')
        <tr>
            <td>
                CPU
            </td>

            <td>
            <input type="text" name="cpu_t" class="form-control input-sm" value="{{$laptop->CPU}}" style="width: 250px">
            </td>

            <td>
                RAM
            </td>

            <td>
                    <select id="ram_t" name="ram_t" class="form-control input-sm" style="width: 130px">
                        @foreach($ram as $rm)
                            <option value='{{$rm->Ram_Size}}' @if($laptop->RAM == $rm->Ram_Size) selected @endif>{{ $rm->Ram_Size }}</option>
                        @endforeach
                    </select>
            </td>
        </tr>
        <tr>
            <td>
                Hard&nbsp;Disk
            </td>

            <td>
                    <select id="hard_disk_t" name="hard_disk_t" class="form-control input-sm" style="width: 130px">
                        @foreach($hard_disk as $hard)
                            <option value='{{$hard->Disk_Size}}' @if($laptop->hard_disk == $hard->Disk_Size) selected @endif>{{ $hard->Disk_Size }}</option>
                        @endforeach
                    </select>
            </td>

            <td>
                OS
            </td>

            <td>
                    <select id="os_t" name="os_t" class="form-control input-sm" style="width: 130px">
                        @foreach($os as $operating)
                            <option value='{{$operating->OS_Name}}' @if($laptop->OS == $operating->OS_Name) selected @endif>{{ $operating->OS_Name }}</option>
                        @endforeach
                    </select>
            </td>
        </tr>
        @endif

        @if($server != '')
        <tr>
            <td>
                Server&nbsp;Classification
            </td>

            <td>
            <input type="text" name="classification_t" class="form-control input-sm" value="{{$server->classification}}" style="width: 250px">
            </td>

            <td>
                No&nbsp;of&nbsp;CPU
            </td>

            <td>
                <input type="text" name="no_of_cpu_t" class="form-control input-sm" value="{{$server->no_of_cpu}}" style="width: 250px">
            </td>
            <td>
        </tr>
        @endif

        @if($virtual_server != '')
        <tr>
            <td>
                Host&nbsp;Server
            </td>

            <td>
            <input type="text" name="host_server_t" class="form-control input-sm" value="{{$virtual_server->host_server}}" style="width: 250px">
            </td>

            <td>
                No&nbsp;of&nbsp;Cores
            </td>

            <td>
                <input type="text" name="no_of_core_t" class="form-control input-sm" value="{{$virtual_server->no_of_cores}}" style="width: 250px">
            </td>
            <td>
        </tr>
        @endif

        @if($dongle != '')
        <tr>
            <td>
                Phone&nbsp;No
            </td>

            <td>
            <input type="text" name="phone_no_t" id="phone_no_t" class="form-control input-sm" value="{{$dongle->phone_no}}" style="width: 250px">
            </td>

            <td>
                Service&nbsp;Provider
            </td>

            <td>
                    <select id="service_provider_t" name="service_provider_t" class="form-control input-sm" style="width: 130px">
                        @foreach($service_provider as $service)
                            <option value='{{$service->Provider_Name}}' @if($dongle->service_provider == $service->Provider_Name) selected @endif>{{ $service->Provider_Name }}</option>
                        @endforeach
                    </select>
            </td>
            <td>
        </tr>

        <tr>
            <td>
                Data&nbsp;Limit
            </td>

            <td>
            <input type="text" name="data_limit_t" class="form-control input-sm" value="{{$dongle->data_limit}}" style="width: 250px">
            </td>

            <td>
                Monthly&nbsp;Rental
            </td>

            <td>
                <input type="text" name="monthly_rental_t" class="form-control input-sm" value="{{$dongle->monthly_rental}}" style="width: 250px">
            </td>
            <td>
        </tr>
        <tr>
            <td>
                Location
            </td>

            <td>
            <input type="text" name="location_t" class="form-control input-sm" value="{{$dongle->location}}" style="width: 250px">
            </td>
        </tr>
        @endif

        @if($client_device != '')
        <tr>
            <td>
                Device&nbsp;Type
            </td>

            <td>
            <input type="text" name="device_type_t" class="form-control input-sm" value="{{$client_device->device_type}}" style="width: 250px">
            </td>

            <td>
                Client&nbsp;Name
            </td>

            <td>
                <input type="text" name="client_name_t" class="form-control input-sm" value="{{$client_device->client_name}}" style="width: 250px">
            </td>
            <td>
        </tr>
        @endif

        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>

            <td style="align-content: right">
            <input type="submit" name="delete" class="btn btn-primary" value="Delete">&nbsp;&nbsp;
            <input type="submit" name="update" class="btn btn-primary" value="Update" onclick="javascript:return validation2()">
            </td>
        </tr>

        </tbody>
    </table>

</div>
{!! Form ::close() !!}
<br/>

@endsection
@stop