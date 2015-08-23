
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}
</style>

<h2 style="color: #9A0000">Other Requests - {{str_replace('_',' ',$id)}}</h2>
<br>


{!! Form ::open(array('url' => 'other-request')) !!}

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

<div class="span12">
    <div class="well">
        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">Request Type</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <select id="request-type" name="request_type" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">

                    @foreach($requestTypes as $type)
                        <?php $name = str_replace('_','-',strtoupper($type->request_type)) ?>
                        <option value='/other-request/{{$type->request_type}}' @if($id==$type->request_type) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-xs-4 col-md-3">
                <label style="font-size: 18px" name="category">Request ID</label>
            </div>

            <div class="col-xs-4 col-md-2">
               {{$key}}
               <input type="hidden" name="request_key" value="{{$key}}">
               <input type="hidden" name="user_id" value="4">
            </div>
        </div>

        <br>

        <div class="row">

            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">From</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <div id="datepicker_start" class="input-append">
                    <input type="text" id="start" name="from_date" data-format="yyyy-MM-dd" class="rounded" placeholder="mm/dd/yyyy" style="height:30px;width: 225px">
                    <span class="add-on" style="height: 30px;">
                    <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                </div>
                <script type="text/javascript">
                        $(function() {
                            var nowDate = new Date();
                            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                           $('#datepicker_start').datetimepicker({
                                pickTime: false,
                                startDate: today
                           });
                        });
                </script>
            </div>

            <div class="col-xs-4 col-md-3">
                <label style="font-size: 18px" name="category">To</label>
            </div>

            <div class="col-xs-4 col-md-2">
                <div id="datepicker_end" class="input-append">
                    <input type="text" id="start" name="to_date" data-format="yyyy-MM-dd" class="rounded" placeholder="mm/dd/yyyy" style="height:30px;width: 225px">
                    <span class="add-on" style="height: 30px;">
                    <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                    </span>
                </div>

                <script type="text/javascript">
                            $(function() {

                                var nowDate = new Date();
                                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                               $('#datepicker_end').datetimepicker({
                                    pickTime: false,
                                    startDate: today
                               });
                            });
                </script>
            </div>
        </div>

        <br>

        <div class="row">

            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">PR Code</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <select name="PR_Code" class="form-control" style="width: 250px">
                    <option value="P001">P001</option>
                    <option value="P002">P002</option>
                    <option value="P003">P003</option>
                </select>
            </div>

            <div class="col-xs-4 col-md-2">
                <input type="button" name="add" class="btn btn-primary form-control" value="+" style="width: 40px; height: 40px; font-size: 18px" onclick="addButton('hardwareTable')">
                <input type="button" name="remove" class="btn btn-primary form-control" value="-" style="width: 40px; height: 40px; font-size: 18px" onclick="removeButton('hardwareTable')">
            </div>
        </div>
    </div>
</div>

<div class="span12" style="overflow:auto;">
    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">

            <th></th>
            @foreach($columns as $c)
                @if($c->table_column != 'request_id' && $c->table_column != 'status')
                <th>{{$c->column_name}}</th>
                @endif
            @endforeach
            <th></th>
        </tr>

        <?php $x=0;
        $columns_to_validate = '';
        ?>
        <tbody id="tableBody">
        <tr id="firstRow">
            <td width="25px">
                <input type='checkbox' class="form-control" style="height: 25px; width: 25px;"/>
            </td>
            @foreach($columns as $c)

                @if($c->table_column != 'request_id' && $c->table_column != 'status')
                <td>
                    @if($c->dropDown == '1' && $x!=$count)
                        <select name='{{$c->table_column}}[]' class="form-control input-sm">
                            @foreach($dropValues[$x] as $v)
                                <option value='{{$v->value}}'>{{ $v->value }}</option>
                            @endforeach
                        </select>
                        <?php $x++; ?>
                    @elseif($c->column_type == 'string')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:130px','class'=>'form-control input-sm'])!!}--}}
                        <input type="text" name='{{$c->table_column}}[]' class="form-control input-sm" >
                    @elseif($c->column_type == 'string_currency' || $c->column_type == 'double' || $c->column_type == 'mediumInteger' || $c->column_type == 'float' || $c->column_type == 'bigInteger')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:90px','class'=>'form-control input-sm'])!!}--}}
                        <input type="text" name='{{$c->table_column}}[]' class="form-control input-sm" >
                    @elseif($c->column_type == 'number' || $c->column_type == 'integer' || $c->column_type == 'tinyInteger' || $c->column_type == 'smallInteger')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:70px','class'=>'form-control input-sm'])!!}--}}
                        <input type="number" name='{{$c->table_column}}[]' value='{{$c->min}}' class="form-control input-sm" min='{{$c->min}}' max='{{$c->max}}'>
                    @elseif($c->column_type == 'date' || $c->column_type == 'datetime')
                        {{--{!! Form :: text($c->table_column.'[]',null,['style'=>'width:135px','class'=>'form-control input-sm'])!!}--}}
                        <input type="date"  name="{{$c->table_column}}[]" class="form-control input-sm datepick" placeholder="mm/dd/yyyy">
                    @endif
                </td>
                @endif
                <?php
                if($c->dropDown != '1')
                    $columns_to_validate = $columns_to_validate.($c->table_column).'-'.($c->validation).'/'; ?>
            @endforeach
            <td>
            <input type="hidden" name="request_id[]" value="{{$key}}">
            <input type="hidden" name="status[]" value="Pending">
            <input type="hidden" name="count[]" value="1">
            </td>
        </tr>

        </tbody>
    </table>
    <input type="hidden" name="columns_valid" value="{{$columns_to_validate}}" id="columns_valid">

</div>

<div class="panel-body" align="right">
{{--{!! Form::submit('Insert',['class' => 'btn btn-primary form-control']) !!}--}}
{!! Form::submit('Request',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validationRequest()']) !!}
{{--{!! Form ::token()!!}--}}
</div>
<br>
{!! Form ::close() !!}

@endsection
@stop