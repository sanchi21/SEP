

@extends('master')

@section('content')

<h2 style="color: #9A0000">Edit Software Resource</h2>

<div align="right"><label><b>Displaying 10 items per page</b></label></div>
@foreach($softwares as $software)
{!! Form ::open(['method' => 'POST', 'action' => ['SoftwareController@update']]) !!}

<div class="panel-body">

    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">
        <tr>
            <td>
                {{--{!!Form::label('inventory_code','Inventory Code',['class'=>'form-control'])!!}--}}
                <label style="color: #9A0000">Inventory&nbsp;Code</label>
            </td>

            <td>
                {{--{!!Form::text('inventory_code_t','CMB/001',['class'=>'rounded','readonly'])!!}--}}
                <label>{{$software->inventory_code}}</label><input type="hidden" name="inventory_code_t" value="{{$software->inventory_code}}">
            </td>
        </tr>

        <tr>
            <td>
                <label>Name</label>
            </td>

            <td>
            {{--{!!Form::text('inventory_code_t','{{$software->name}}',['class'=>'rounded'])!!}--}}
            <input type="text" name="name_t" class="rounded" value="{{$software->name}}" size="50px">
            </td>
        </tr>

        <tr>
            <td>
                <label>Vendor</label>
            </td>

            <td>
            {{--{!!Form::text('inventory_code_t','{{$software->vendor}}',['class'=>'rounded'])!!}--}}
            <input type="text" name="vendor_t" class="rounded" value="{{$software->vendor}}" size="50px">
            </td>
        </tr>

        <tr>
            <td>
                <label>No&nbsp;of&nbsp;License</label>
            </td>

            <td>
                {{--{!!Form::text('inventory_code_t','{{$software->no_of_license}}',['class'=>'rounded'])!!}--}}
                <input type="number" name="no_of_license_t" class="rounded" value="{{$software->no_of_license}}" min="1" max="100" size="50px">
            </td>
        </tr>

        <tr>
            <td>
            </td>

            <td>
            {{--{!! Form::submit('Delete&nbsp;',['class' => 'btn btn-primary']) !!}&nbsp;&nbsp;--}}
            {{--{!! Form::submit('Update',['class' => 'btn btn-primary']) !!}--}}
            <input type="submit" name="delete" class="btn btn-primary" value="Delete&nbsp;">&nbsp;&nbsp;
            <input type="submit" name="update" class="btn btn-primary" value="Update">
            </td>
        </tr>

        </tbody>
    </table>

</div>
{!! Form ::close() !!}
<br/>
<line></line>
@endforeach
<div align="center">
{!!$softwares->render()!!}
</div>

@endsection
@stop