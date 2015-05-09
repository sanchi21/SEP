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

<table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial " >
 <tbody>
 <th>Type</th>
 <th>Protocol</th>
 <th>Port</th>
 <th>Sever Name</th>
 <th>IP Address</th>

 <tr>

     <td>
       <select class="form-control" name="connectivity" style="width: 250px">
         @foreach($connectivity as $conn)
          <option>
            {{$conn->connectivity}}
          </option>
         @endforeach
       </select>
     </td>
     <td>
       <select class="form-control" name="protocol" style="width: 250px">
        @foreach($protocols as $protocol)
           <option>
             {{$protocol->protocol}}
           </option>
        @endforeach
       </select>
     </td>
     <td><input type="text" class="form-control" name="port" id="port" style="height: 30px "placeholder="Port" tabindex="1" value="" /></td>
     <td><input type="text" class="form-control" name="sever" id="sever" style="height: 30px "placeholder="Sever" tabindex="1" value="" /></td>
     <td><input type="text" class="form-control" name="ip" id="ip" style="height: 30px "placeholder="Ip Address" tabindex="1" value="" /></td>

 </tr>
</tbody>
</table>

<div style="margin-left:0.2cm"> {!! Form::submit('Send',['class'=>'sbtn','name'=>'connect']) !!}</div></br>

<div style="margin-left:0.2cm">{!! Form::submit('View',['class'=>'sbtn','name'=>'view']) !!}</div></br></br>

 @if(Session::has('flash_av'))
 <p style="color: darkred"><b>Project Code: {{$project_id}}</b></p>
  <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial " >
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

{!! Form::close() !!}
@endsection