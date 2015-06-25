@extends('master')

@section('content')


<h2 style="color: #9A0000">Request</h2>

<div class="panel-body">
<form action="{{ URL::route('requestRes') }}" method="post">
    <p style="margin-left: 1cm;margin-top: 0.5cm;width: 5%;font-size: small;font-family: Arial">
    {{--<b><h3 style="color: darkred">Request</h3></b>--}}

<div class="well">
    <div class="row">
            <div class="col-xs-2 col-md-2" style="width: 150px">
                <label style="font-size: 18px">Start Date</label>
            </div>

            <div class="col-xs-2 col-md-2">
            <div id="datepicker_start" class="input-append">
                <input type="text" id="start" name="start_date" data-format="yyyy-MM-dd" class="rounded" placeholder="mm/dd/yyyy" style="height:30px;width: 150px">
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

            <div class="col-xs-2 col-md-2" style="width: 150px">
                <label style="font-size: 18px;">End Date</label>
            </div>

            <div class="col-xs-2 col-md-2">
                <div id="datepicker_end" class="input-append">
                    <input type="text" id="start" name="end_date" data-format="yyyy-MM-dd" class="rounded" placeholder="mm/dd/yyyy" style="height:30px;width: 150px">
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

            <div class="col-xs-2 col-md-2" style="width: 150px">
                <label style="font-size: 18px">PR Code</label>
            </div>

            <div class="col-xs-2 col-md-2" style="width: 250px">
                <select class="form-control" name="project_id" >
                      @foreach($pros as $pro)
                        <option>
                        {{$pro->os_version}}
                        </option>
                      @endforeach
                    </select>
            </div>
    </div>
</div>

    </br>
<div>
    <div class="row">
            <div class="col-xs-4 col-md-4">
                <h3>Hardware</h3>
            </div>

        <div class="col-xs-2 col-md-2">
            <h3><input type="button" value="+"  class="sbtn" style="width: 35px;height: 35px" onClick="add_Row('dataTable')" />&nbsp;
            <input type="button" value="-" class="sbtn" style="width: 35px;height: 35px" onClick="delete_Row('dataTable')" /></h3>
        </div>
    </div>
</div>

    </p>

    <table class="table table-hover" width="100%" style="margin-bottom: 1px">
    <tr id="headRow" style="background-color: #e7e7e7;">
            <th width="3%"></th>
            <th width="27%">Item</th>
            <th width="70%">Additional Information</th>
        </tr>
    </table>
    <table id="dataTable" class="table table-hover" width="100%">
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

  	<td width="27%">
  	{{--{!! Form::label('item','Item') !!}--}}
    <select class="form-control" name="item[]">
  	              <option>Select Type</option>
                  @foreach($types as $type)
                      <option>
                        {{$type->category}}
                      </option>
                  @endforeach
              </select>
  	</td>
  	{{--<td>--}}
  	{{--<!--get versions into dropdown -->--}}
  	{{--{!! Form::label('os_version','OS') !!}--}}
  	{{--<select class="form-control" name="os_version[]" >--}}
                     {{--@foreach($versions as $version)--}}
                        {{--<option>--}}
                          {{--{{$version->OS_Name}}--}}
                        {{--</option>--}}
                     {{--@endforeach--}}
                  {{--</select>--}}
  	{{--</td>--}}
  	<td>
  	<!-- text area to get additional information-->
  	{{--{!! Form::label('additional_information','Additional_Information')!!}--}}
  	{!! Form::textarea('additional_information[]',null,['class'=>'form-control','style'=>'height:33px']) !!}
  	</td>
    </tr>
   </tbody>
   </table>

  <!--hidden field to count rows  -->
   <input type="hidden" id = "test" name="test">

<br>
   {{--<p style="margin-left: 1cm;margin-top: 0.5cm;width: 5%;font-size: small;font-family: Arial">--}}

   <div>
       <div class="row">
               <div class="col-xs-4 col-md-4">
                   <h3>Software</h3>
               </div>

           <div class="col-xs-2 col-md-2">
               <h3><input type="button" value="+"  class="sbtn" style="width: 35px;height: 35px" onClick="add_Row('Table2')" />&nbsp;
               <input type="button" value="-" class="sbtn" style="width: 35px;height: 35px"  onClick="delete_Row('Table2')" /></h3>
           </div>
       </div>
   </div>

   {{--</p>--}}

    <table class="table table-hover" width="100%" style="margin-bottom: 1px">
        <tr id="headRow" style="background-color: #e7e7e7;">
            <th width="3%"></th>
            <th width="22%">Device Type</th>
            <th width="10%">No&nbsp;of&nbsp;License</th>
            <th width="65%">Additional Information</th>
        </tr>
    </table>
   <table id="Table2" class="table table-hover">
   <tbody>
   <tr>
   <p>
   <td width="3%">
      <input type='checkbox' />
   </td>
   <td width="22%">
      {{--{!! Form::label('device_type','Device-Type') !!}--}}
      <select class="form-control" name="device_type[]">
          <option>Select Device</option>
          @foreach($sws as $sw)
            <option>
                {{$sw->name}}
            </option>
          @endforeach


      </select>
   </td>
   <td width="10%">
      {{--{!! Form::label('model','No Of License') !!}--}}
      <input type="number" name="model[]" min="0" style="height: 33px; width: 100%" class="form-control"/>
   </td>
   <td width="65%">
      {{--{!! Form::label('additional_information_sw','Additional_Information')!!}--}}
      {!! Form::textarea('additional_information_sw[]',null,['class'=>'form-control','style'=>'height:33px']) !!}
   </td>
    </p>
    </tr>
   </tbody>
   </table>

   <input type="hidden" id ="test1" name="test1">

   {{--<div class="form-group" style="width: 20%;margin-left: 0.25cm">--}}
        <div align="right">
     {!! Form::submit('Request',['class'=>'sbtn','name'=>'request','onClick'=>'Both()']) !!}
     </div>
     {!! Form::token() !!}
   {{--</div>--}}

   </br>

   <div class="form-group" style="width: 10%;margin-left: 0.25cm">
  {!! Form::submit('View',['class'=>'sbtn','name'=>'view']) !!}
    </div>

 @if(Session::has('flash_view'))
    <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial" >
    <tbody>
    <tr style="width: 20%;background-color: #e7e7e7;">
         <td align="left">{!! Form::label('request_id','Request_ID') !!} </td>
         <td align="left">{!! Form::label('sub_id','Sub_ID') !!} </td>
         <td align="left">{!! Form::label('item','Item') !!} </td>
         {{--<td align="left">{!! Form::label('os_version','OS') !!} </td>--}}
         <td align="left">{!! Form::label('device_type','Device_Type')!!} </td>
         <td align="left">{!! Form::label('model','Model')!!} </td>
         <td align="left">{!! Form::label('additional_information','Additional_Information')!!} </td>
         <td></td>
    </tr>

   <!--Get all requests made by pr -->

    @foreach($all_requests as $all)
    <form action="{{ URL::route('requestRes') }}" method="post">
    <tr>
       <td>{{$all->request_id}}</td>
       <td>{{$all->sub_id}}</td>
       <td>{{$all->item}}</td>
       {{--<td>{{$all->os_version}}</td>--}}
       <td>{{$all->device_type}}</td>
       <td>{{$all->model}}</td>
       <td>{{$all->additional_information}}</td>
       <input type="hidden" value="{{$all->request_id}}" name="hid1">
       <input type="hidden" value="{{$all->sub_id}}" name="hid2">
       {!! Form::token() !!}
       <td> {!! Form::submit('Cancel',['class'=>'btn btn-danger form-control','name'=>'cancel']) !!}</td>

      </tr>
      </form>
    @endforeach

    </tbody>
    </table>
  @endif

</form>

   {!! Form::close() !!}
</div>

   <script>
   function add_Row(tableID) {
   	var table = document.getElementById(tableID);
   	var rowCount = table.rows.length;

   		var row = table.insertRow(rowCount);
   		var colCount = table.rows[0].cells.length;
   		for(var i=0; i<colCount; i++) {
   			var newcell = row.insertCell(i);
   			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
   		}
   		}

   function delete_Row(tableID) {
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





 @endsection



