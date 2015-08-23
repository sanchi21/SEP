@extends('master')
@section('content')

{!! Form::open() !!}
  <h3 style="color: maroon">Request For Connectivity</h3></br>

      <table width="70%">
         <tr>
             <td width="20%"><h4>&nbsp;&nbsp;PR&nbsp;Code</h4></td>
             <td>
                 <select class="form-control" name="project_id" style="width: 250px">
                    @foreach($pros as $pro)
                       <option>
                               {{$pro->os_version}}
                       </option>
                    @endforeach
                 </select>
             </td>
         </tr>
      </table>
</br>

  <div>
       <div class="row">
           <div class="col-xs-4 col-md-4"></div>

           <div class="col-xs-2 col-md-2">
               <h3><input type="button" value="+"  class="sbtn" style="width: 35px;height: 35px" onClick="add_Row_connectivity('Table3')" />&nbsp;
               <input type="button" value="-" class="sbtn" style="width: 35px;height: 35px"  onClick="delete_Row_connectivity('Table3')" /></h3>
           </div>
       </div>
  </div>


  <table class="table table-hover" style="font-size: small;font-family: Arial " >

        <tr id="headRow" style="background-color: #e7e7e7;">
            <th width="4%"></th>
            <th width="24%">Type</th>
            <th width="24%">Protocol</th>
            <th width="16%">Port</th>
            <th>Sever Name</th>
            <th>IP Address</th>
        </tr>
  </table>

  <table id="Table3" class="table table-hover">
        <tbody>

        <tr>
            <style>
                   input[type="checkbox"]{
                   width: 30px; /*Desired width*/
                   height: 30px; /*Desired height*/
                   }
            </style>

            <td width="3%">
                <input type='checkbox' class="form-control"/>
            </td>
            <td>
                <select class="form-control" name="connectivity[]" style="width: 250px">
                    @foreach($connectivity as $conn)
                        <option>
                                {{$conn->connectivity}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control" name="protocol[]" style="width: 250px">
                    @foreach($protocols as $protocol)
                        <option>
                               {{$protocol->protocol}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control" name="port[]" id="port[]" style="height: 30px "placeholder="Port" tabindex="1" value="" /></td>
            <td><input type="text" class="form-control" name="sever[]" id="sever[]" style="height: 30px "placeholder="Sever" tabindex="1" value="" /></td>
            <td><input type="text" class="form-control" name="ip[]" id="ip[]" style="height: 30px "placeholder="Ip Address" tabindex="1" value="" /></td>

        </tr>
        </tbody>
  </table>

  <!--hidden field to count rows  -->
  <input type="hidden" id = "count_rows" name="count_rows">

  <div style="margin-left:0.2cm"> {!! Form::submit('Send',['class'=>'sbtn','name'=>'connect' ,'onClick'=>'getRow_connectivity()']) !!}</div></br>

  <div  align="right">{!! Form::submit('View',['class'=>'sbtn','name'=>'view']) !!}</div></br></br>


  @if(Session::has('flash_av'))
  @if($project_id !=null)
      <p style="color: darkred"><b>Project Code&nbsp;-&nbsp;{{$project_id}}</b></p>

      <table id="Table4"  class="table table-hover" style="font-size: small;font-family: Arial " >

      <tbody>
            <th>Request No</th>
            <th>Sub Id</th>
            <th>Type</th>
            <th>Protocol</th>
            <th>Port</th>
            <th>Sever Name</th>
            <th>IP Address</th>

      @foreach($all_table as $all)
           @if($all->sub_id ==null)
                <p>no results</p>
           @else
                <tr>
                    <td>{{$all->request_id}}</td>
                    <td>{{$all->sub_id}}</td>
                    <td>{{$all->type}}</td>
                    <td>{{$all->protocol}}</td>
                    <td>{{$all->port}}</td>
                    <td>{{$all->sever_name}}</td>
                    <td>{{$all->ip_address}}</td>
                </tr>
           @endif
      @endforeach

      </tbody>
      </table>

  @endif
  @endif

  {!! Form::close() !!}

  <script>

    function add_Row_connectivity(tableID) {
   	    var table = document.getElementById(tableID);
   	    var rowCount = table.rows.length;

   		var row = table.insertRow(rowCount);
   		var colCount = table.rows[0].cells.length;
   		for(var i=0; i<colCount; i++) {
   			var newcell = row.insertCell(i);
   			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
   		}
   	}

    function delete_Row_connectivity(tableID) {
   	    var table = document.getElementById(tableID);
     	var rowCount = table.rows.length;
   	    for(var i=0; i<rowCount; i++) {
   		   var row = table.rows[i];
   		   var chkbox =row.querySelector('input[type=checkbox]');
   		   if(null != chkbox && true == chkbox.checked) {
   			  if(rowCount <= 1) {               // limit the user from removing all the fields
   				 alert("Cannot Remove all the requests..");
   				 break;
   			  }
   			  table.deleteRow(i);
   			  rowCount--;
   			  i--;
   		   }
   	    }

    }

    function getRow_connectivity(Table3){
         var x = document.getElementById("Table3").rows.length;
         document.getElementById("count_rows").value=x;

    }

  </script>



@endsection