

@extends('master')

@section('content')

<h2 style="color: #9A0000">Edit Hardware Resource</h2>

{!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@update']]) !!}
{{--<div class="alert alert-danger" id="error_msg" style="display: none">--}}

         {{--<label id="msg"></label>--}}
         {{--</div>--}}
         @if($errors->any())
                  <div class="alert alert-danger" id="error_msg">
                     <ul style="list-style: none">
                     @foreach($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                     </ul>
                  </div>
                  @endif

<br>
<div class="panel-body">
<h3>{{$type}}</h3><input type="hidden" name="type" id="type" value="{{$type}}">
<br>
    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">

        <?php $x = 0;
         $y = 0;?>

        @foreach($columns as $col)

            <?php
               $attribute = $col->table_column;
            ?>

            @if($x == 0)
                <tr>
            @elseif($x % 2 == 0)
                </tr>
                <tr>
            @endif
                <td>
                    {{$col->column_name}}
                </td>
                <td>
                    @if($attribute == 'inventory_code')
                        {{$hardware->inventory_code}}<input type="hidden" name="inventory_code" value="{{$hardware->inventory_code}}">
                    @else
                        @if($col->dropDown == '1' && $y!=$count)
                            <select style="width: 250px" name='{{$col->table_column}}' class="form-control input-sm">
                                @foreach($dropValues[$y] as $v)
                                    <option value='{{$v->value}}' @if($hardware->$attribute == $v->value) selected @endif>{{ $v->value }}</option>
                                @endforeach
                            </select>
                            <?php $y++; ?>
                        {{--@elseif($col->column_type == 'string')--}}
                            {{--{!! Form :: text($col->table_column,$hardware->$attribute,['style'=>'width:250px','class'=>'form-control input-sm'])!!}--}}
{{--                            <input type="text" name='{{$col->table_column}}' id='{{$col->table_column}}' class="form-control input-sm" value='{{$hardware->$attribute}}' style="width:250px">--}}
                        {{--@elseif($col->column_type == 'string_currency' || $col->column_type == 'double' || $col->column_type == 'mediumInteger' || $col->column_type == 'float' || $col->column_type == 'bigInteger')--}}
                            {{--<input type="text" name='{{$col->table_column}}' id='{{$col->table_column}}' class="form-control input-sm" value='{{$hardware->$attribute}}' style="width:250px">--}}
                            {{--{!! Form :: text($col->table_column,$hardware->$attribute,['style'=>'width:250px','class'=>'form-control input-sm'])!!}--}}
                        {{--@elseif($col->column_type == 'double' || $col->column_type == 'number' || $col->column_type == 'integer' || $col->column_type == 'tinyInteger' || $col->column_type == 'smallInteger')--}}
                            {{--<input type="number" name='{{$col->table_column}}' id='{{$col->table_column}}' value='{{$hardware->$attribute}}' class="form-control input-sm" min='{{$col->min}}' style="width:250px">--}}
                            {{--{!! Form :: text($col->table_column,$hardware->$attribute,['style'=>'width:250px','class'=>'form-control input-sm'])!!}--}}
                        {{--@elseif($col->column_type == 'date' || $col->column_type == 'datetime')--}}
                        @else
                            {{--<input type="date" name="{{$col->table_column}}" id='{{$col->table_column}}' class="form-control input-sm" placeholder="mm/dd/yyyy" value='{{$hardware->$attribute}}' style="width:250px">--}}
                            {!! Form :: text($col->table_column,$hardware->$attribute,['style'=>'width:250px','class'=>'form-control input-sm'])!!}
                        @endif
                    @endif
                </td>
                <?php $x++; ?>

        @endforeach

        @if($x % 2 != 0)
            <td></td>
            <td></td>
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
            {{--<input type="submit" name="update" class="btn btn-primary" value="Update" onclick="javascript:return validation2()">--}}
            <input type="submit" name="update" class="btn btn-primary" value="Update">
            </td>
        </tr>

        </tbody>
    </table>

</div>
{!! Form ::close() !!}
<br/>

@endsection
@stop