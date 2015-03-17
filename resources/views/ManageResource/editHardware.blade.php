

@extends('...master')

@section('content')

<h2>Edit Hardware Resource</h2>

{!! Form ::open(array('url' => 'hardware')) !!}
<div class="well">

    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">
            <tr>
                <td>
                {!!Form::label('inventory_code','Inventory Code',['class'=>'form-control'])!!}
                </td>

                <td>
                {!!Form::text('input','inventory_code_t[]','CMB/001',['class'=>'form-control'])!!}
                </td>
            </tr>

        </tbody>
    </table>

</div>

{!! Form ::close() !!}
@endsection
@stop
