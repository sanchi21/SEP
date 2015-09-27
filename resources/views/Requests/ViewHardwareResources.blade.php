<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 23/8/2015
 * Time: 10:45 AM
 */
 ?>
 @extends('master')
 @section('content')

 <script src="src/jquery.table2excel.js"></script>


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


<h3><b>{{$inventoryType}}</b></h3>
<h4 style="color: #9A0000"><b>{{$inventory_code}}</b></h4>
</br>
<table class="table table-hover" id="table_ID">

    <tr>
        <th>Project Code</th>
        <th>Request Id</th>
        <th>Inventory code</th>
        <th>Assigned Date</th>
        <th>Remarks</th>
        <th>Current Status</th>
    </tr>
     <?php $value=0  ?>
     @foreach($results as $result)

     <tr>
        <td>{{$projectCodes[$value]}}</td>
        <td>{{$result->request_id}}</td>
        <td>{{$result->inventory_code}}</td>
        <td>{{$result->assigned_date}}</td>
        <td>{{$result->remarks}}</td>
        <td>{{$result->status}}</td>
     </tr>

    <?php $value++  ?>
    @endforeach

</table>


<tr><input type="button"  class="btn btn-success form-control" style="width: 10%" onclick="tableToExcel('table_ID','Inventory')" value="Save To File"></tr>

@endsection