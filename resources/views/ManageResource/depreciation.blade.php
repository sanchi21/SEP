
@extends('master')

@section('content')


<script type="text/javascript">
    $(document).ready(function() {
        $('#inventory').multiselect({
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>

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
    .dropdown-menu
    {
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:100px;
    }
</style>


<h2 style="color: #9A0000">Asset Depreciation</h2>

<br>

<div class="well">

    <table width="100%">
    <tr>

        <td width="15%">
            <label style="width: 90px">Inventory&nbsp;Code</label>
        </td>
        <td>
            <select id="inventory" name="inventory" class="form-control input-sm" style="width: 250px" onchange="javascript:location.href = this.value;">
                @foreach($inventory as $inv)
                    <option value="/hardware-depreciation/{{$inv->inventory_code}}" @if($hardware->inventory_code == $inv->inventory_code) selected @endif>{{ $inv->inventory_code }}</option>
                @endforeach
                <option value="/hardware-depreciation/{{$inv->inventory_code}}">{{ $inv->inventory_code }}</option>
            </select>
        </td>

    </tr>
    </table>

</div>

<div align="right">
    <input type="button"  class="btn btn-success" style="height:36px" onclick="tableToExcel('printTable','Depreciation')" value="Export to Excel">&nbsp;
    <input type="button" onclick="printContent('content12')" class="btn btn-primary" value="Print">&nbsp;&nbsp;
</div>


<div class="container">

    <table width="100%">
        <tr>
            <td valign="top" width="40%">
                <h3 style="color: #9A0000">Asset Details</h3>
                    <table class="table table-bordered" >
                        <tr style="height: 50px">
                            <td><strong>Inventory&nbsp;Code</strong></td>
                            <td>{{$hardware->inventory_code}}</td>
                        </tr>



                        <tr style="height: 50px">
                            <td><strong>Category</strong></td>
                            <td>{{$hardware->type}}</td>
                        </tr>



                        <tr style="height: 50px">
                            <td><strong>Value At Cost</strong></td>
                            <td>{{$hardware->value}}</td>
                        </tr>

                        <tr style="height: 50px">
                            <td><strong>Date Purchased</strong></td>
                            <td>{{$hardware->purchase_date}}</td>
                        </tr>

                    <br>
                    </table>
                    <div  style="width:500px">
                        <br>
                        <h3 style="color: #9A0000">Depreciation Table</h3>
                        <br>
                        <table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="70%" style="font-size: 15px;">
                            <tr id="headRow" style="background-color: #e7e7e7;">
                                <th>Year</th>
                                <th>Depreciation</th>
                                <th>Net&nbsp;Book&nbsp;Value</th>
                            </tr>

                            <tbody id="tableBody">
                            <?php $x=0; $gYear=''; $gValue=''; $gDep=''; ?>
                                @foreach($depreciate as $year => $value)
                                <tr>
                                    <td width="20%">
                                        {{$year}}
                                        <?php
                                            if($x==0)
                                                $gYear = $gYear.$year;
                                            else
                                                $gYear = $gYear.','.$year; ?>
                                    </td>

                                    <td width="40%">
                                        {{$dVal[$x]}}
                                    </td>

                                    <td width="40%">
                                        {{$value}}
                                        <?php
                                            if($x==0)
                                                {
                                                    $gValue = $gValue.$value;
                                                    $gDep = $dVal[$x];
                                                }
                                            else
                                                {
                                                    $gValue = $gValue.','.$value;
                                                    $gDep = $gDep.','.$dVal[$x];
                                                } ?>
                                    </td>
                                </tr>
                            <?php $x++ ?>
                                @endforeach

                            <input type="hidden" id="gYear" value="{{$gYear}}">
                            <input type="hidden" id="gValue" value="{{$gValue}}">
                            <input type="hidden" id="gDep" value="{{$gDep}}">

                            </tbody>
                        </table>
                    </div>
            </td>

            <td width="10%">
                &nbsp;&nbsp;&nbsp;
            </td>

            <td width="50%" valign="top">
                <h3 style="color: #9A0000">Graphical View of the Asset Value</h3>
                <br>
                <div>
                    <canvas id="depreciate" width="600px" height="300px"></canvas>
                    <script>

                        var gYear = document.getElementById('gYear').value;
                        var gValue = document.getElementById('gValue').value;
                        var gLabel = gYear.split(",");
                        var gData = gValue.split(",");

                        var depreciateData = {
                            labels : gLabel,
                            datasets : [
                                {
                                    fillColor : "rgba(255,255,255,0.4)",
                                    strokeColor : "#ACC26D",
                                    pointColor : "#fff",
                                    pointStrokeColor : "#9DB86D",
                                    data : gData
                                }
                            ]
                        }

                        var depreciate = document.getElementById('depreciate').getContext('2d');
                        new Chart(depreciate).Line(depreciateData);
                    </script>
                </div>

            </td>
        </tr>
    </table>

</div>



                            {{-- Print --}}

<div class="panel-body" name="content12" id="content12" style="display: none">

<div name = "report-header">
        <table width="100%">
            <tr>
                <td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>
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

        <h2 align="center">Hardware Asset Valuation</h2>

    </div>
<br>
    <table width="100%">
            <tr>
                <td valign="top" width="40%">
                        <h3 style="color: #9A0000">Asset Details</h3>
                        <table class="table table-bordered" >
                            <tr style="height: 50px">
                                <td><strong>Inventory&nbsp;Code</strong></td>
                                <td>{{$hardware->inventory_code}}</td>
                            </tr>



                            <tr style="height: 50px">
                                <td><strong>Category</strong></td>
                                <td>{{$hardware->type}}</td>
                            </tr>



                            <tr style="height: 50px">
                                <td><strong>Value At Cost</strong></td>
                                <td>{{$hardware->value}}</td>
                            </tr>

                            <tr style="height: 50px">
                                <td><strong>Date Purchased</strong></td>
                                <td>{{$hardware->purchase_date}}</td>
                            </tr>

                        <br>
                        </table>
                        <div  style="width:500px">
                        <br>
                        <h3 style="color: #9A0000">Depreciation Table</h3>
                        <br>
                            <table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="70%" style="font-size: 15px;">
                                <tr id="headRow" style="background-color: #e7e7e7;">
                                    <th>Year</th>
                                    <th>Depreciation</th>
                                    <th>Net&nbsp;Book&nbsp;Value</th>
                                </tr>

                                <tbody id="tableBody">
                                <?php $x=0; $gYear=''; $gValue=''; ?>
                                    @foreach($depreciate as $year => $value)
                                    <tr>
                                        <td width="20%">
                                            {{$year}}
                                            <?php
                                                if($x==0)
                                                    $gYear = $gYear.$year;
                                                else
                                                    $gYear = $gYear.','.$year; ?>
                                        </td>

                                        <td width="40%">
                                            {{$dVal[$x]}}
                                        </td>

                                        <td width="40%">
                                            {{$value}}
                                            <?php
                                                if($x==0)
                                                    $gValue = $gValue.$value;
                                                else
                                                    $gValue = $gValue.','.$value; ?>
                                        </td>
                                    </tr>
                                <?php $x++ ?>
                                    @endforeach

                                <input type="hidden" id="gYear" value="{{$gYear}}">
                                <input type="hidden" id="gValue" value="{{$gValue}}">

                                </tbody>
                            </table>
                        </div>
                </td>

                <td width="10%">
                    &nbsp;&nbsp;&nbsp;
                </td>

                <td width="50%" valign="top">
                    <h3 style="color: #9A0000">Graphical View of the Asset Value</h3>
                    <br>
                    <div>
                        <img src="" id="graph">
                    </div>
                </td>
            </tr>
        </table>


</div>


<div class="panel-body" style="display: none">
    <table class="table table-bordered" id="printTable" cellpadding="0" cellspacing="0" width="70%" style="font-size: 15px;">
        <tr id="headRow" style="background-color: #e7e7e7;">
            <th>Year</th>
            <th>Depreciation</th>
            <th>Net&nbsp;Book&nbsp;Value</th>
        </tr>

        <tbody id="tableBody">
        <?php $x=0;?>
            @foreach($depreciate as $year => $value)
            <tr>
                <td width="20%">
                    {{$year}}
                </td>

                <td width="40%">
                    {{$dVal[$x]}}
                </td>

                <td width="40%">
                    {{$value}}
                </td>
            </tr>
        <?php $x++ ?>
            @endforeach
        </tbody>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr style="background-color: #e7e7e7;">
            <th>Inventory Code</th>
            <th>Category</th>
            <th>Value At Cost</th>
        </tr>
        <tr>
            <td>{{$hardware->inventory_code}}</td>
            <td>{{$hardware->type}}</td>
            <td>{{$hardware->value}}</td>
        </tr>
    </table>
</div>


@endsection
@stop



<script>
    function printContent(print_content){

        drawGraph();
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(print_content).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>

<script>
    function drawGraph()
    {
        var canvas = document.getElementById("depreciate");
        var img    = canvas.toDataURL("image/png");
        //document.write('<img src="'+img+'"/>');
        document.getElementById('graph').src=img;
    }
        </script>

<script src="/includes/js/draw.min.js"></script>