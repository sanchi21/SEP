@extends('...master')


@section('content')

<script>
 var tableToExcel = (function() {
   var uri = 'data:application/vnd.ms-excel;base64,'
     , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
   return function(table, name) {
     if (!table.nodeType) table = document.getElementById(table)
     var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
     window.location.href = uri + base64(format(template, ctx))
   }
 })()
</script>



<style>

    .table>tbody>tr>td {
        padding: 3px;
    }

    .dropdown-menu {
    max-height: 310px;
    overflow-y: auto;
    overflow-x: hidden;
    }

    .multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:120px;
    }

    .hideextra { white-space: nowrap; overflow: hidden; text-overflow:ellipsis; }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('#columns').multiselect({
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#group_by').multiselect({
        enableFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>


<h2 style="color: #9A0000">Advanced Querying</h2>
<br>

    <div  align="right">
        <input type="button"  class="btn btn-success" style="height:36px" onclick="tableToExcel('printTable','Inventory')" value="Export to Excel">&nbsp;
        <input type="button"  class="btn btn-primary" style="width:90px; text-align: center" onclick="printContent('content12')" value="Print">&nbsp;&nbsp;&nbsp;&nbsp;
    </div>


{!! Form ::open(['method' => 'POST', 'action' => ['PrintResourceController@generateReport']]) !!}
@if($errors->any())
 <div class="alert alert-danger" id="error_msg">
    <ul style="list-style: none">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
 </div>
 @endif

<div class="alert alert-danger" id="error_msg1" style="display: none">
    <label id="msg"></label>
</div>

<div class="panel-body" style="min-height: 520px">
<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <label style="font-size: 18px" name="request">Hardware&nbsp;Category</label>
        </div>

        <div class="col-xs-4 col-md-4">

            <select id="category" name="category" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
    	        @foreach($types as $type)
    	       	    <option value='/hardware-report/{{$type->category}}' @if($type->category == $category) selected @endif>{{ $type->category }}</option>
    	        @endforeach
            </select>

        </div>

        <div class="col-xs-4 col-md-3">
            <label style="font-size: 18px" name="column">Columns</label>
        </div>

        <div class="col-xs-4 col-md-2">
            <select id="columns" name="columns[]" class="form-control input-sm" style="width: 180px; min-height: 30px" multiple="multiple">

                @foreach($columns as $col)

                    <?php
                        $sTemp = false;
                        $sCols = $selected['sColumn'];
                        if(count($sCols)>0)
                        {
                            foreach ($sCols as $sCol)
                            {
                                if($sCol == $col->table_column)
                                {
                                    $sTemp = true;
                                    break;
                                }
                            }
                        }
                        else
                            $sTemp = true;
                    ?>
                    <option value='{{$col->table_column}}' @if($sTemp) selected @endif>{{ $col->column_name }}</option>
                @endforeach

            </select>
        </div>

    </div>

    <br>

        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="group">Group&nbsp;By</label>
            </div>


            <div class="col-xs-4 col-md-4">
                <select id="group_by" name="group_by[]" class="form-control" style="width: 180px; min-height: 30px" multiple="multiple">

                    @foreach($columns as $col)

                    <?php
                        $gTemp = false;
                        $sCols = $selected['sGroup'];
                        if(count($sCols)>0)
                        {
                            foreach ($sCols as $sCol)
                            {
                                if($sCol == $col->table_column)
                                {
                                    $gTemp = true;
                                    break;
                                }
                            }
                        }
                    ?>

                        <option value='{{$col->table_column}}' @if($gTemp) selected @endif>{{ $col->column_name }}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-xs-4 col-md-3">
                <label style="font-size: 18px" name="od">Order&nbsp;By</label>
            </div>

            <div class="col-xs-4 col-md-2">

                <table>
                <tr>
                <?php $oTemp = $selected['sOrder']; ?>
                    <td>
                        @if($oTemp[1] == 'asc')
                            <a class="btn btn-success" style="height: 32px" id="orderButton" onclick="changeOrder()"><span id="orderSpan" class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
                        @else
                            <a class="btn btn-danger" style="height: 32px" id="orderButton" onclick="changeOrder()"><span id="orderSpan" class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>
                        @endif
                        <input type="hidden" name="order" id="order" value="{{$oTemp[1]}}">
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                        <select name="order_by" class="form-control" style="width: 202px">
                            @foreach($columns as $col)
                                <option value='{{$col->table_column}}' @if($oTemp[0] == $col->table_column) selected @endif>{{ $col->column_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                </table>
            </div>

        </div>

    <br>

        <div class="row">
                <div class="col-xs-4 col-md-2">
                    <label style="font-size: 18px" name="dt">Date&nbsp;Field</label>
                </div>


                <div class="col-xs-4 col-md-4">

                    <?php
                        $sDt = $selected['sdt'];
                    ?>
                    <select name="date" class="form-control" style="width: 250px">
            	            <option value='None' @if($sDt == 'None') selected @endif>None selected</option>
            	        @foreach($dateColumns as $col)
                            <option value='{{$col->table_column}}' @if($sDt == $col->table_column) selected @endif>{{ $col->column_name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-xs-4 col-md-3">
                    <label style="font-size: 18px" name="v">Value&nbsp;Field</label>
                </div>


                <div class="col-xs-4 col-md-2">

                     <?php
                        $sVl = $selected['sVl'];
                     ?>
                     <select name="value" class="form-control" style="width: 250px">
                        <option value='None' selected>None selected</option>
                        @foreach($valueColumns as $col)
                            <option value='{{$col->table_column}}' @if($sVl == $col->table_column) selected @endif>{{ $col->column_name }}</option>
                        @endforeach
                    </select>

                </div>
        </div>

        <br>

        <div class="row">
                <div class="col-xs-4 col-md-2">
                    <label style="font-size: 18px" name="dt">Date&nbsp;Between</label>
                </div>


                <div class="col-xs-4 col-md-4">
                <?php $stDt = $selected['sDtBt'] ?>
                <table>
                    <tr>
                        <td>
                            <input type="date"  name="start_date" class="form-control datepick" placeholder="mm/dd/yyyy" value="{{$stDt[0]}}" style="width:120px">
                        </td>

                        <td>&nbsp;&nbsp;</td>

                        <td>
                            <input type="date"  name="end_date" class="form-control datepick" placeholder="mm/dd/yyyy" value="{{$stDt[1]}}" style="width:120px">
                        </td>
                    </tr>
                </table>

                </div>
                <div class="col-xs-4 col-md-3">
                    <label style="font-size: 18px" name="v">Value&nbsp;Between</label>
                </div>


                <div class="col-xs-4 col-md-2">
                <?php $stVl = $selected['sVlBt'] ?>
                    <table>
                        <tr>
                            <td>
                                <input type="text"  name="value_start" class="form-control" value="{{$stVl[1]}}" style="width:120px">
                            </td>

                            <td>&nbsp;&nbsp;</td>

                            <td>
                                <input type="text"  name="value_end" class="form-control" value="{{$stVl[1]}}" style="width:120px">
                            </td>
                        </tr>
                    </table>

                </div>
        </div>
</div>

<div align="right">

    {!! Form::submit('Retrieve',['class' => 'btn btn-primary form-control']) !!}

</div>
<br>
{!! Form ::close() !!}

<div style="overflow:auto; min-height:300px; max-height: 700px">

    @if($hardwares != '')

    <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">

        <?php
        $sel =  '';
        if(count($selected['sColumn'])>0)
            $sel = $selected['sColumn'];
        else
            $sel = $columns;
        ?>

        <tr id="headRow" style="background-color: #e7e7e7;">
            @foreach($sel as $c)
            <?php $tm='';?>

                @foreach($columns as $cc)
                    @if($c == $cc->table_column)
                        <?php $tm = str_replace(' ','&nbsp;', $cc->column_name) ?>
                    @endif
                @endforeach

                <th>{{$tm}}</th>

            @endforeach
            <th></th>
        </tr>

        <tbody id="tableBody">

        @foreach($hardwares as $hardware)
        <tr>
            @foreach($sel as $col)
            <td>
                <div class="hideextra">
                <?php $attribute = $col; ?>
                {{$hardware->$attribute}}
                </div>
            </td>
            @endforeach
        </tr>
        @endforeach

        </tbody>

    </table>

    @endif
</div>

</div>


                        {{-------------------        Print      --------------------}}

<div id="content12" name="content12" style="display: none">

<div name = "report-header">
        <table width="100%">
            <tr>
                {{--<td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>--}}
                <td width="50%"><img src="/includes/images/zone_logo.png" height="30px" width="90px"></td>
                <td width="50%"></td>
            </tr>
            <tr>
                <td width="50%"><h4>Zone24x7 (Private) Limited</h4></td>
                <td width="50%" align="right"><h4>Date : {{date("d-m-Y")}}</h4></td>
            </tr>

            <tr>
                <td width="50%"><h4>Nawala Road,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Koswatte,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Sri Lanka 10107</h4></td>
                <td></td>
            </tr>

        </table>

        <h2 align="center">Hardware Details</h2>

    </div>
<br>
 @if($hardwares != '')

<table class="table table-bordered" id="printTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <?php
            $sel =  '';
            if(count($selected['sColumn'])>0)
                $sel = $selected['sColumn'];
            else
                $sel = $columns;
            ?>

            <tr id="headRow" style="background-color: #e7e7e7;">
                @foreach($sel as $c)
                <?php $tm='';?>

                    @foreach($columns as $cc)
                        @if($c == $cc->table_column)
                            <?php $tm = str_replace(' ','&nbsp;', $cc->column_name) ?>
                        @endif
                    @endforeach

                    <th>{{$tm}}</th>

                @endforeach
                <th></th>
            </tr>

            <tbody id="tableBody">

            @foreach($hardwares as $hardware)
            <tr>
                @foreach($sel as $col)
                <td>
                    <div class="hideextra">
                    <?php $attribute = $col; ?>
                    {{$hardware->$attribute}}
                    </div>
                </td>
                @endforeach
            </tr>
            @endforeach
    </tbody>
</table>

@endif

</div>


                        {{----------------------------------------------------------}}



@endsection
@stop


<script>
    function printContent(print_content){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(print_content).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>

<script>
function changeOrder()
{
    var val = document.getElementById('order').value;

    if(val == 'asc')
    {
        document.getElementById('orderButton').className = "btn btn-danger";
        document.getElementById('orderSpan').className = "glyphicon glyphicon-chevron-down";
        document.getElementById('order').value = 'desc';
    }
    else if(val == 'desc')
    {
        document.getElementById('orderButton').className = "btn btn-success";
        document.getElementById('orderSpan').className = "glyphicon glyphicon-chevron-up";
        document.getElementById('order').value = 'asc';
    }
}
</script>