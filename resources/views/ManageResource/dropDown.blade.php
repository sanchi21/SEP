
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 3px;
}
</style>

<h2 style="color: #9A0000">Drop Down Items</h2>
<br>

    @if($errors->any())
        <div class="alert alert-danger" id="error_msg">
            <ul style="list-style: none">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="panel-body" style="overflow:auto; min-height: 200px">

    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">
            <th>Attribute</th>
            <th>Values</th>
            <th>Add/Edit</th>
            <th>Operation</th>
        </tr>

            <tbody id="tableBody">
            <?php $x = 0; ?>
            @foreach($columns as $column)

            {!! Form ::open(['method' => 'POST', 'action' => ['DropDownController@handle']]) !!}

                <tr id="firstRow">
                <td width="20%">
                    {{$column->column_name}}
                    <input type="hidden" name="table_column" value="{{$column->table_column}}">
                </td>

                <td width="25%">
                @if($x<$count)
                    <select style="width: 250px" id="" name='dropDown' class="form-control input-sm">
                        @foreach($dropValues[$x] as $dropValue)
                            <option value='{{$dropValue->did}}'>{{ $dropValue->value }}</option>
                        @endforeach
                    </select>
                @endif

                <?php $x++; ?>
                </td>

                <td width="25%">
                    <input type="text" name='new_value' class="form-control input-sm" style="width:250px">
                </td>

                <td width="30%">
                    <input type="submit" name="add_button" value="Add" class="btn btn-primary form-control" style="width:85px">
                    &nbsp;<input type="submit" name="update_button" value="Update" class="btn btn-success form-control" style="width:85px">
                    &nbsp;<input type="submit" name="delete_button" value="Delete" class="btn btn-danger form-control" style="width:85px">
                </td>
                </tr>

                {!! Form ::close() !!}

                @endforeach
            </tbody>

        </table>

        <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
            {!! Form ::open(array('url' => 'change-option')) !!}
            <tr>
                <td width="20%">
                    Request Item
                </td>

                <td width="25%">
                    <select style="width: 250px" id="" name='dropDown' class="form-control input-sm">
                        @foreach($items as $item)
                            <option value='{{$item->key}}'>{{ $item->category }}</option>
                        @endforeach
                    </select>
                </td>
                <td width="25%">
                    <input type="text" name='new_value' class="form-control input-sm" style="width:250px">
                </td>
                <td width="30%">
                    <input type="submit" name="add_button" value="Add" class="btn btn-primary form-control" style="width:85px">
                    &nbsp;<input type="submit" name="update_button" value="Update" class="btn btn-success form-control" style="width:85px">
                    &nbsp;<input type="submit" name="delete_button" value="Delete" class="btn btn-danger form-control" style="width:85px">
                </td>
            </tr>
            {!! Form ::close() !!}
</div>

<br>

@endsection
@stop