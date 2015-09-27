@extends('master')

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
.hideextra { white-space: nowrap; overflow: hidden; text-overflow:ellipsis; }
</style>



<h2 style="color: #9A0000">Hardware Categories Summary</h2>
<br>

<div align="right">
    <input type="button"  class="btn btn-success" style="height:36px" onclick="tableToExcel('printTable','Category_Summary')" value="Export to Excel">&nbsp;
    <input type="button" onclick="printContent('content12')" class="btn btn-primary" value="Print">&nbsp;&nbsp;
</div>


<div class="panel-body">
<form>
<table width="100%">
    <tr>
        <td valign="top" width="50%">
        <h3 style="color: #9A0000">Category Details</h3>
        <br>
        <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">

        <th>Category</th>
        <th>Count</th>
        <th>Total Value</th>

    </tr>

    <tbody id="tableBody">

    <?php $x=0; $type=''; $count=''; $total=''; ?>

    @foreach($category as $hardware)

    <tr>

        <td>
            <div class="hideextra">
                {{$hardware->type}}
            </div>
            <?php
            if($x==0)
                $type = $type.$hardware->type;
            else
                $type = $type.','.$hardware->type; ?>
        </td>

        <td>
            <div class="hideextra">
                {{$hardware->catCount}}
            </div>
            <?php
                if($x==0)
                    $count = $count.$hardware->catCount;
                else
                    $count = $count.','.$hardware->catCount; ?>
        </td>

        <td>
            <div class="hideextra">
                {{$hardware->total}}
            </div>
           <?php
               if($x==0)
                   $total = $total.$hardware->total;
               else
                   $total = $total.','.$hardware->total; ?>
        </td>

    </tr>
    <?php $x++; ?>
    @endforeach

    <input type="hidden" id="type" value="{{$type}}">
    <input type="hidden" id="count" value="{{$count}}">
    <input type="hidden" id="total" value="{{$total}}">

    </tbody>
</table>

        </td>

        <td width="10%">
            &nbsp;&nbsp;&nbsp;
        </td>

        <td width="40%" valign="top">
            <h3 style="color: #9A0000">Pie Chart View - Category Count</h3>
            <br>
            <div>

                <canvas id="types" width="350" height="350"></canvas>

                    <div id="typeLabel">
                    <ul id="list" style="list-style-type: square;font-size: 20px">
                                    </ul>
                    </div>

                <script>

                var pieOptions = {
                    segmentShowStroke : false,
                    animateScale : false
                }

                var type = document.getElementById('type').value;
                var tLable = type.split(",");

                var count = document.getElementById('count').value;
                var tCount = count.split(",");
                var data = [];
                var ul = document.getElementById("list");

                for(var x=0 ; x<tCount.length ; x++)
                {
                    var col = getRandomColor();
                    var obj = {value : tCount[x],
                               color : col,
                               label : tLable[x],
                               labelColor : 'white',
                               labelFontSize : '16'
                              };
                    data.push(obj);

                    var li = document.createElement("li");
                    li.style.color = col;
                    li.appendChild(document.createTextNode(tLable[x]));
                    ul.appendChild(li);
                }

                //var tData = [{value:50,color:'red'},{value:50,color:'blue'}];


                var pieData = data;
                var types= document.getElementById("types").getContext("2d");
                new Chart(types).Pie(pieData, pieOptions);

               </script>
            </div>


        </td>
     </tr>
</table>
<div style="overflow: auto" align="left">
        <br>
        <h3 style="color: #9A0000">Bar Graph View - Resource Value</h3>
        <br>
        <canvas id="tValue" width="1000px" height="400"></canvas>


        <script>

            var type = document.getElementById('type').value;
            var total = document.getElementById('total').value;
            var tLable = type.split(",");
            var tData = total.split(",");

            var barData = {
                labels : tLable,
                datasets : [
                    {
                        fillColor : "#48A497",
                        strokeColor : "#48A4D1",
                        data : tData
                    }
                ]
            }
            var income = document.getElementById("tValue").getContext("2d");
            new Chart(income).Bar(barData);

                   </script>
            </div>
</form>
</div>





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

        <h2 align="center">Hardware Category Summary</h2>

    </div>
<br>

<div class="panel-body">
<form>
<table width="100%">
    <tr>
        <td valign="top" width="50%">
        <h3 style="color: #9A0000">Category Details</h3>
        <br>
        <table class="table table-bordered" id="printTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">

        <th>Category</th>
        <th>Count</th>
        <th>Total Value</th>

    </tr>

    <tbody id="tableBody">

    @foreach($category as $hardware)

    <tr>

        <td>
            <div class="hideextra">
                {{$hardware->type}}
            </div>

        </td>

        <td>
            <div class="hideextra">
                {{$hardware->catCount}}
            </div>

        </td>

        <td>
            <div class="hideextra">
                {{$hardware->total}}
            </div>

        </td>

    </tr>

    @endforeach



    </tbody>
</table>

        </td>

        <td width="10%">
            &nbsp;&nbsp;&nbsp;
        </td>

        <td width="40%" valign="top">
        <h3 style="color: #9A0000">Pie Chart View - Category Count</h3>
        <br>
            <div>
                <img src="" id="graph">
            </div>
            <div id="typeLabel2">
            </div>

        </td>
     </tr>
</table>
    <div align="left">
        <br>
        <h3 style="color: #9A0000">Bar Graph View - Resource Value</h3>
        <br>

        <div>
            <img src="" id="barGraph">
        </div>
    </div>

</form>
</div>
</div>

@endsection
@stop

<script>
    function drawGraph()
    {
        var canvas = document.getElementById("types");
        var img    = canvas.toDataURL("image/png");

        document.getElementById('graph').src=img;

        var canvas = document.getElementById("tValue");
        var img    = canvas.toDataURL("image/png");

        document.getElementById('barGraph').src=img;

        var typeLabel = document.getElementById('typeLabel');
        var typeLabel2 = document.getElementById('typeLabel2');
        $('#typeLabel').clone().appendTo('#typeLabel2');
    }
</script>

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


<script src="/includes/js/draw.min.js"></script>
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>