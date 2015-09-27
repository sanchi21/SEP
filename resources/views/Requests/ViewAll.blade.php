@extends('master')
@section('content')



<div id="content" name="content">
 <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial ;width:30%;margin-left: 2cm" >
 <tbody>
  <p><b>Project code :: {{$project_code}}</b></p></br>
  <input type="button" class="btn btn-primary form-control" style="float: right;width:50px" value="Print" onclick="printAllocation('divCheckbox')"></button>

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
  <div id="divCheckbox" style="display: none;">

       <table width="100%">
                           <tr>
                               <td width="50%">
                                   <img src="/includes/images/zone_logo.png" height="70px" width="200px">
                               </td>
                               <td width="50%"></td>
                           </tr>
                           <tr>
                               <td width="50%">
                                   <h4>Zone24x7 (Private) Limited</h4>
                               </td>
                               <td width="50%" align="right">
                                   <h4>Date : {{date("d-m-Y")}}</h4>
                               </td>
                           </tr>

                           <tr>
                               <td width="50%">
                                   <h4>Nawala Road,</h4>
                               </td>
                               <td></td>
                           </tr>

                           <tr>
                               <td width="50%">
                                   <h4>Koswatte,</h4>
                               </td>
                               <td></td>
                           </tr>

                           <tr>
                               <td width="50%">
                                   <h4>Sri Lanka 10107</h4>
                               </td>
                               <td></td>
                           </tr>

       </table>

                       <h2 align="center">Resource Allocation Report</h2>
                       </br>

                        <table id="Table"  class="table table-hover" style="font-size:large;font-family: Arial ;width:100%" >
                        <tbody>
                         <p><b>Project code :: {{$project_code}}</b></p></br>
                                @foreach($results as $result)

                                @if($result->item == '')
                                <p style="color: #337ab7"><b>Software Resource</b></p></br>


                                <tr>

                                     <th>ID</th>
                                     <th>Device Type</th>
                                     <th>Allocated License</th>
                                     <th>Allocated Inventory Code</th>
                                     <th>Assigned Date</th>
                                     <th>Remarks</th>

                                </tr>


                                <tr>
                                  <td>{{$result->sub_id}}</td>
                                  <td>{{$result->device_type}}</td>
                                  <td>{{$result->model}}</td>
                                  <td>{{$result->inventory_code}}</td>
                                  <td>{{$result->assigned_date}}</td>
                                  <td>{{$result->remarks}}</td>

                                </tr>



                                @else

                                  <tr>

                                       <th>ID</th>
                                       <th>Hardware Device</th>
                                       <th>OS Version</th>
                                       <th>Allocated Inventory Code</th>
                                       <th>Assigned Date</th>
                                       <th>Remarks</th>

                                  </tr>

                                  <tr>
                                        <td>{{$result->sub_id}}</td>
                                        <td>{{$result->item}}</td>
                                        <td>{{$result->os_version}}</td>
                                        <td>{{$result->inventory_code}}</td>
                                        <td>{{$result->assigned_date}}</td>
                                        <td>{{$result->remarks}}</td>

                                  </tr>

                                </br>
                                @endif

                                @endforeach
                         </tbody>
                         </table>

  </div>


 <script>
     function printAllocation(divCheckbox){
         var restorepage = document.body.innerHTML;
         //var printcontent = document.getElementById(content).innerHTML;
         var printcontent1 = document.getElementById(divCheckbox).innerHTML;
         document.body.innerHTML = printcontent1;
         window.print();
         document.body.innerHTML = restorepage;
     }
</script>

@endsection