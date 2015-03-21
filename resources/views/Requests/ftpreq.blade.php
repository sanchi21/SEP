
@extends('master')

 @section('content')


 <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script src="http://www.bootply.com/plugins/bootstrap-select.min.js"></script>

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



 <h3 style="color: maroon">Request</h3></br>
 <p style="width: 20%">{!! Form::text ('project_id',null,['class'=>'form-control',' placeholder'=>'Project ID']) !!}</p></br>

 <h4>Request for FTP Account</h4>
 <table class="table table-hover" style="width: 20%">
 <tbody>
 <td >{!! Form::submit('Send',['class'=>'btn btn-info form-control','name'=>'ftp']) !!}</td>
 </tbody>
 </table>
 </br>

<h4>Request For Shared Folder </h4>
<table class="table table-hover" style="width: 50%">
<tbody>
<tr>
<td>{!! Form::label('Users','Users') !!}</td>
<td>
   <select name="user[]" class="selectpicker" multiple >
      @foreach($sys_users as $user)
         <option>
           {{$user->username}}
          </option>
      @endforeach
   </select>

</td>
</tr>

<td  style="width:40%">{!! Form::submit('Send',['class'=>'btn btn-info form-control','name'=>'folder']) !!}</td>
</tbody>
</table>

 {!! Form::close() !!}


 <script src="//code.jquery.com/jquery.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

 </body>
 @endsection



