@extends('master')
@section('content')

{{--<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">--}}



<script type="text/javascript">
                $(document).ready(function() {
                    $('#hw').multiselect({
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '350px'
                    });
                });
</script>
<style>
    .dropdown-menu
    {
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .btn
    {
    text-align: left;
    }

    .multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:210px;
    }
</style>

<style>
    .table-hover-l>tbody>tr>td
    {
        line-height: 0px solid #ddd;
        border-top: none;
    }
</style>

<h2 style="color: #9A0000">Hardware Maintenance</h2>

{!! Form::open() !!}
<div class="panel-body" style="min-height: 500px">

    {{--<div style="float:left; width:50%">--}}

    <p></p></br>
    <div class="panel panel-default" style="width: 98%">
        <div class="panel-heading" style="color: #9A0000"><h4>Add Maintenance Cost</h4></div>
            <div class="panel-body">
                <table id="Table1"  class="table table-hover-l" style="width: 97%">
                <tbody>
                    <tr>
                        <td><label>Hardware Inventory Code</label></td>
                        <td>
                            <select id="hw" name="hw"  style="width: 180px; min-height: 30px">
                            @foreach($hardware as $hw)
                                <option>
                                    {{$hw->inventory_code}}
                                </option>
                            @endforeach
                            </select>
                        </td>

                        <td><label>Remarks</label></td>
                        <td><input type="text" class="form-control" name="remarks" id="remarks" style="height:30px;width: 350px" placeholder="Remarks" tabindex="1" value="" /></td>
                    </tr>

                    <tr>
                        <td><label>Date</label></td>
                        <td>
                            <div class="col-xs-2 col-md-2" style="margin-left: -15px">
                                <div id="datepicker_start" class="input-append">
                                    <input type="text" id="date" name="date" data-format="yyyy-MM-dd" class="rounded" placeholder="yyyy-mm-dd" style="width:320px">
                                    <span class="add-on" style="height: 30px;">
                                    <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                    </span>
                                </div>

                            <script type="text/javascript">
                            $(function()
                            {
                                var nowDate = new Date();
                                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                                $('#datepicker_start').datetimepicker({
                                    pickTime: false,
                                    startDate: today
                                });
                             });
                             </script>
                            </div>
                        </td>

                        <td><label>Cost</label></td>
                        <td><input type="text" class="form-control" name="cost" id="cost" style="height:30px;width:350px" placeholder="Cost" tabindex="1" value="" /></td>
                    </tr>


                </tbody>
                </table>

                <div class="panel-body" align="right">
                    {!! Form::submit('Save',['class'=>'sbtn','name'=>'save']) !!}
                    {!! Form::submit('Retrieve',['class'=>'sbtn','name'=>'view']) !!}
                </div>
            </div>
    </div>

    </br>
    {{--<div style="float:right; width:50%">--}}
    </br>

    <div class="panel panel-default" style="width: 98%">
        <div class="panel-heading" style="color: #9A0000"><h4>Maintenance Cost</h4></div>
            <div class="panel-body">

                </br>

            @if(Session::has('flash_total_c'))
                <table class="table table-hover">
                    <tr style="background-color: #f5f5f5;">
                        <th>Remarks</th>
                        <th>Date</th>
                        <th cl>Cost (Rs)</th>
                    </tr>
                    @foreach($finds as $fin)
                    <tr>
                    {{--<td>Remarks</td>--}}
                        <td>{{$fin->remarks}}</td>
                        {{--<td></td>--}}

                        {{--<td>Date</td>--}}
                        <td>{{$fin->date}}</td>
                        {{--<td></td>--}}
                        {{--</tr>--}}
                        {{--<tr class="info">--}}
                        {{--<td class="info"><b>Cost</b></td>--}}
                    {{--<td> </td>--}}
                        <td align="right"><b>{{$fin->cost}}.00</b></td>
                    </tr>

                @endforeach

                    <tr class="danger">
                        <td><p style="color: darkred"><b>Total</b></p></td>
                        <td></td>
                        <td align="right"><p style="color: darkred"><b>{{$total_cost}}.00</b></p></td>
                    </tr>

                </table>
            @endif
            </div>
    </div>

</div>
{!! Form::close() !!}
@endsection