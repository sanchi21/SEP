@extends('master')
@section('content')



<div id="content" name="content">
 <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial ;width:30%;margin-left: 2cm" >
 <tbody>
  <p><b>Project code :: {{$project_code}}</b></p></br>
         @foreach($results as $result)

         @if($result->item == '')
         <tr>
            <td><p style="color: #337ab7"><b>Software Resource</b></p></td>
         </tr>
         <tr>
            <td>Id</td>
            <td> {{$result->sub_id}}</td>
         </tr>
         <tr>
            <td>Device Type</td>
            <td>{{$result->device_type}}</td>
         </tr>
         <tr>
            <td>Allocated Licence</td>
            <td>{{$result->model}}</td>
         </tr>
         <tr>
            <td><b>Allocated Inventory Code</b></td>
            <td><b>{{$result->inventory_code}}</b></td>
         </tr>
         <tr>
            <td><b>Assigned Date</b></td>
            <td><b>{{$result->assigned_date}}</b></td>
         </tr>
         <tr>
            <td>Remarks</td>
            <td>{{$result->remarks}}</td>
         </tr>

         @else
         <tr>
            <td><p style="color: darkred"><b>Hardware Resource</b></p></td>
         </tr>
         <tr>
            <td>Id</td>
            <td> {{$result->sub_id}}</td>
         </tr>
         <tr>
            <td>Hardware Device</td>
            <td>{{$result->item}}</td>
         </tr>
         <tr>
            <td>OS Version</td>
            <td>{{$result->os_version}}</td>
         </tr>
         <tr>
            <td><b>Allocated Inventory Code</b></td>
            <td><b>{{$result->inventory_code}}</b></td>
         </tr>
         <tr>
            <td><b>Assigned Date</b></td>
            <td><b>{{$result->assigned_date}}</b></td>
         </tr>
         <tr>
            <td>Remarks</td>
            <td>{{$result->remarks}}</td>
         </tr>

         @endif
         @endforeach

 </tbody>
 </table>
  </div>
 <input type="button" class="btn btn-primary form-control" value="Print" onclick="printAllocation('content')"></button>

 <script>
     function printAllocation(content){
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(content).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
</script>

@endsection