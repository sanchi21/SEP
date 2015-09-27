
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}
</style>

<h2 style="color: #9A0000">New Hardware Resource</h2>
<br>

{!! Form ::open(array('url' => 'hardware')) !!}

        @if($errors->any())
         <div class="alert alert-danger" id="error_msg">
            <ul style="list-style: none">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
         </div>
         @endif
         <div class="alert alert-danger" id="error_msg" style="display: none">
         <label id="msg"></label>
         </div>
<div class="span12" style="overflow:auto; min-height: 120px">
    <div class="well">
        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 20px" name="cat">Category</label>
            </div>


            <div class="col-xs-4 col-md-4">
                <label style="font-size: 20px" name="cate">{{$category}}</label>
                <input type="hidden" name="category" value="{{'1111111111'.$category}}">
            </div>

            <div class="col-xs-4 col-md-2">
                <label style="font-size:20px" name="quantity">Quantity</label>
            </div>

            <div class="col-xs-4 col-md-2">
                <label style="font-size: 20px" name="qt">{{$item->quantity}}</label>
                <input type="hidden" name="quantity" value="{{$item->quantity}}">
            </div>

        </div>
    </div>



    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">

            @foreach($columns as $c)
                <th>{{$c->column_name}}</th>
            @endforeach
        </tr>

        <?php $x=0;
        $columns_to_validate = '';
        ?>
        <tbody id="tableBody">

        @for($q=0 ; $q<$item->quantity ; $q++)
        <?php $x=0;

            $newCode='';
            if($q == 0)
                $newCode = $key;
            else
            {
                $newNumber = substr($key, 8);

                $newCode = substr($key, 0, 8);
                $newNumber = $newNumber + $q;
                $count = strlen($newNumber);

                if ($count == 1)
                    $newCode = $newCode . "000" . $newNumber;
                elseif ($count == 2)
                    $newCode = $newCode . "00" . $newNumber;
                elseif ($count == 3)
                    $newCode = $newCode . "0" . $newNumber;
            }
        ?>


        <tr id="firstRow">

            @foreach($columns as $c)
                <td>
                @if($c->table_column == 'inventory_code')
                    <input style="width: 130px" type="text" id="inventory_code_t" name="inventory_code[]" class="form-control input-sm" value="{{$newCode}}" readonly>
                @elseif($c->table_column == 'description')
                    <input type="text" name='{{$c->table_column}}[]' value="{{$item->description}}" class="form-control input-sm" style="width:130px">
                @elseif($c->table_column == 'value')
                    <input type="text" name='{{$c->table_column}}[]' value="{{$item->price}}" class="form-control input-sm" style="width:90px">
                @elseif($c->table_column == 'warranty')
                    <input type="text" name='{{$c->table_column}}[]' value="{{$item->warranty}}" class="form-control input-sm" style="width:90px">
                @else
                    @if($c->dropDown == '1' && $x!=$count)
                        <select style="width: 130px" id="screen_size_t" name='{{$c->table_column}}[]' class="form-control input-sm">
                            @foreach($dropValues[$x] as $v)
                                <option value='{{$v->value}}'>{{ $v->value }}</option>
                            @endforeach
                        </select>
                        <?php $x++; ?>
                    @elseif($c->column_type == 'string')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:130px','class'=>'form-control input-sm'])!!}--}}
                        <input type="text" name='{{$c->table_column}}[]' class="form-control input-sm" style="width:130px">
                    @elseif($c->column_type == 'string_currency' || $c->column_type == 'double' || $c->column_type == 'mediumInteger' || $c->column_type == 'float' || $c->column_type == 'bigInteger')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:90px','class'=>'form-control input-sm'])!!}--}}
                        <input type="text" name='{{$c->table_column}}[]' class="form-control input-sm" style="width:90px">
                    @elseif($c->column_type == 'number' || $c->column_type == 'integer' || $c->column_type == 'tinyInteger' || $c->column_type == 'smallInteger')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:70px','class'=>'form-control input-sm'])!!}--}}
                        <input type="number" name='{{$c->table_column}}[]' value='{{$c->min}}' class="form-control input-sm" min='{{$c->min}}' max='{{$c->max}}' style="width:70px">
                    @elseif($c->column_type == 'date' || $c->column_type == 'datetime')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:135px','class'=>'form-control input-sm'])!!}--}}
                        <input type="date"  name="{{$c->table_column}}[]" class="form-control input-sm datepick" placeholder="mm/dd/yyyy" style="width:135px">
                    @endif

                @endif
                </td>
                <?php
                if($c->dropDown != '1' && $q==0)
                    $columns_to_validate = $columns_to_validate.($c->table_column).'-'.($c->validation).'/'; ?>
            @endforeach

        </tr>

        @endfor
            <input type="hidden" name="columns_valid" value="{{$columns_to_validate}}" id="columns_valid">
        </tbody>
    </table>

</div>

<div class="panel-body" align="right">
{{--{!! Form::submit('Insert',['class' => 'btn btn-primary form-control']) !!}--}}
{!! Form::submit('Insert',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validation()']) !!}
{{--{!! Form ::token()!!}--}}
</div>
<br>
{!! Form ::close() !!}

@endsection
@stop
