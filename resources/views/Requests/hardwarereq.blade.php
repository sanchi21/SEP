@extends('master')

 @section('content')


 <head>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <script>
   $(document).ready(function(){
       $("button").click(function(){
           $("#Table3").toggle();
       });
   });
   </script>

</head>

 <body>

    {!! Form::open() !!}

      <div >
        @if(Session::has('flash_message'))
         <div class="alert alert-info">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         {{Session::get('flash_message')}}</div>
        @endif
       </div>


    <p style="margin-left: 1cm;margin-top: 0.5cm;width: 5%;font-size: small;font-family: Arial">
    <b><h3 style="color: darkred">Request</h3></b>
    <table>
    <td  style="font-size: small;font-family: Arial">
        {!! Form::text('start_date',null,['class'=>'form-control','placeholder'=>'Required From','id'=>'start']) !!}
    </td>
    <td  style="font-size: small;font-family: Arial">
        {!! Form::text ('end_date',null,['class'=>'form-control','placeholder'=>'Required Upto','id'=>'end']) !!}
    </td>
    <td style="font-size: small;font-family: Arial">
        {!! Form::text ('project_id',null,['class'=>'form-control','placeholder'=>'Project ID']) !!}
    </td>
    </table>
    </br>

    <h4>Hardware</h4>
    <table class="table table-hover" style="width: 10%">
    <td> <input type="button" value="+"  class="btn btn-info  form-control" onClick="addRow('dataTable')" /></td>
    <td> <input type="button" value="-" class="btn btn-info  form-control"  onClick="deleteRow('dataTable')" /></td>
    </table>

    </p>

    <table id="dataTable" class="table table-hover" style="font-size: small;font-family: Arial" >
    <tbody>
    <tr>
  	<p>
  	<td >
  		<input type='checkbox' />
  	</td>
  	<td>
  	<!-- get item values in to dropdown  -->
  	{!! Form::label('item','Item') !!}
  	  <select class="form-control" name="item[]">
                  @foreach($types as $type)
                      <option>
                        {{$type->type}}
                      </option>
                  @endforeach
              </select>
  	</td>
  	<td>
  	<!--get versions into dropdown -->
  	{!! Form::label('os_version','OS') !!}
  	<select class="form-control" name="os_version[]" >
                     @foreach($versions as $version)
                        <option>
                          {{$version->os_version}}
                        </option>
                     @endforeach
                  </select>
  	</td>
  	<td>
  	<!-- text area to get additional information-->
  	{!! Form::label('additional_information','Additional_Information')!!}
  	{!! Form::textarea('additional_information[]',null,['class'=>'form-control','style'=>'height:33px']) !!}
  	</td>
  	</p>
    </tr>
   </tbody>
   </table>

  <!--hidden field to count rows  -->
   <input type="hidden" id = "test" name="test">


   <p style="margin-left: 1cm;margin-top: 0.5cm;width: 5%;font-size: small;font-family: Arial">
   <h4>Software</h4>
   <table class="table table-hover" style="width: 10%">

   <!--buttons for adding and removing table rows -->
   <td> <input type="button" value="+"  class="btn btn-info  form-control" onClick="addRow('Table2')" /></td>
   <td> <input type="button" value="-" class="btn btn-info  form-control"  onClick="deleteRow('Table2')" /></td>

   </table>
   </p>

   <table id="Table2" class="table table-hover" style="font-size: small;font-family: Arial" >
   <tbody>
   <tr>
   <p>
     	<td >
     		<input type='checkbox' />
     	</td>
     	<td>
     	{!! Form::label('device_type','Device-Type') !!}
     	  <select class="form-control" name="device_type[]">
                     @foreach($types as $type)
                         <option>
                           {{$type->type}}
                         </option>
                     @endforeach
                 </select>
     	</td>
     	<td>
     	{!! Form::label('model','Model') !!}
     	<select class="form-control" name="model[]" >
                        @foreach($versions as $version)
                           <option>
                             {{$version->os_version}}
                           </option>
                        @endforeach
                     </select>
     	</td>
     	<td>
     	{!! Form::label('additional_information_sw','Additional_Information')!!}
     	{!! Form::textarea('additional_information_sw[]',null,['class'=>'form-control','style'=>'height:33px']) !!}
     	</td>
    </p>
    </tr>
    </tbody>
   </table>

   <input type="hidden" id ="test1" name="test1">

   <div class="form-group" style="width: 10%;margin-left: 0.25cm">
     {!! Form::submit('Request',['class'=>'btn btn-info form-control','onClick'=>'Both()']) !!}
   </div>
   </br>


   {!! Form::close() !!}


   <script>
   function addRow(tableID) {
   	var table = document.getElementById(tableID);
   	var rowCount = table.rows.length;

   		var row = table.insertRow(rowCount);
   		var colCount = table.rows[0].cells.length;
   		for(var i=0; i<colCount; i++) {
   			var newcell = row.insertCell(i);
   			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
   		}
   		}

   function deleteRow(tableID) {
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

   function Both(){
   getRow(dataTable);
   getSw(Table2);

   }

   function getRow(dataTable){
      var x = document.getElementById("dataTable").rows.length;
      document.getElementById("test").value=x;

   }
   function getSw(Table2){
      var y= document.getElementById("Table2").rows.length;
      document.getElementById("test1").value=y;
   }
   </script>

     <meta charset="utf-8">
     <title>jQuery UI Datepicker - Default functionality</title>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
     <script src="//code.jquery.com/jquery-1.10.2.js"></script>
     <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
     <link rel="stylesheet" href="/resources/demos/style.css">


           <script>
           $(function() {
              $("#start" ).datepicker();
              $("#end").datepicker();
           });
          </script>

 <script src="//code.jquery.com/jquery.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


 <div class="form-group" style="width: 10%;margin-left: 0.25cm">
 {!! Form::button('View',['class'=>'btn btn-info form-control']) !!}
 </div>

 <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial" >
 <tbody>
 <tr style="width: 20%">
      <td></td>
      <td align="left">{!! Form::label('request_id','Request_ID') !!} </td>
      <td align="left">{!! Form::label('sub_id','Sub_ID') !!} </td>
      <td align="left">{!! Form::label('item','Item') !!} </td>
      <td align="left">{!! Form::label('os_version','OS') !!} </td>
      <td align="left">{!! Form::label('device_type','Device_Type')!!} </td>
      <td align="left">{!! Form::label('model','Model')!!} </td>
      <td align="left">{!! Form::label('additional_information','Additional_Information')!!} </td>
 </tr>

<!--Get all requests made by pr -->
 @foreach($all_requests as $all)
 <tr>
    <td ><input type='checkbox' name="view[]" id="view_tb"/></td>
    <td>{{$all->request_id}}</td>
    <td>{{$all->sub_id}}</td>
    <td>{{$all->item}}</td>
    <td>{{$all->os_version}}</td>
    <td>{{$all->device_type}}</td>
    <td>{{$all->model}}</td>
    <td>{{$all->additional_information}}</td>


  </tr>
 @endforeach

 </tbody>
 </table>

 </body>
 @endsection



