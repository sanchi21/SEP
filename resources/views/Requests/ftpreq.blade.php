
@extends('master')

 @section('content')
 <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<script type="text/javascript">
                $(document).ready(function() {
                    $('#user').multiselect({
                    enableFiltering: true,
                    buttonWidth: '350px'
                    });
                });
</script>

 {{--<head>--}}
  {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">--}}
  {{--<script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>--}}
  {{--<script src="http://www.bootply.com/plugins/bootstrap-select.min.js"></script>--}}
  {{--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>--}}
     {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>--}}
     <script>
     $(document).ready(function(){
         $("button").click(function(){
             $("#Table3").toggle();
             $("#Table4").toggle();
         });
     });
     </script>
     {{--<script src="/js/Bootstrap/Select/bootstrap-select.js"></script>--}}

 {{--</head>--}}
 {{--<body>--}}

{!! Form::open() !!}

    {{--<div >--}}
         {{--@if(Session::has('flash_message'))--}}
          {{--<div class="alert alert-info">--}}
          {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
          {{--{{Session::get('flash_message')}}</div>--}}
         {{--@endif--}}
        {{--</div>--}}



 <h3 style="color: maroon">Request For Account And Folder</h3></br>

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

 <table class="table table-hover" width="70%">
 <tbody>
 <td> <h4>Request for FTP Account</h4></td>
 <td style="width: 15%">{!! Form::submit('Send',['class'=>'sbtn','name'=>'ftp']) !!}</td>
 </tbody>
 </table>
 </br>

<table class="table table-hover" >
<tbody>
<tr>
<td style="width: 30%"><h4>Request For Shared Folder </h4></td>
<td><h4>{!! Form::label('Users','Users:') !!}</h4></td>
<td >
<select id="user" name="user[]" multiple="multiple" style="height:33px">
             @foreach($sys_users as $user)
                     <option>
                       {{$user->username}}
                      </option>
                  @endforeach
     </select>

</td>
<td  style="width: 15%">{!! Form::submit('Send',['class'=>'sbtn','name'=>'folder']) !!}</td>
</tr>
</tbody>
</table>

<div class="form-group" style="width: 10%;margin-left: 0.25cm">
 {!! Form::button('View',['class'=>'sbtn','name'=>'view']) !!}
 </div>

 <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial" >
 <tbody>
 <tr style="width: 20%" class="info">
      <td align="left">{!! Form::label('request_id','Request_ID') !!} </td>
      <td align="left">{!! Form::label('sub_id','Sub_ID') !!} </td>
      <td align="left">{!! Form::label('type','Type') !!} </td>


 </tr>

<!--Get all requests made by pr -->
 @foreach($ftp as $f)
 <tr>
    <td>{{$f->request_id}}</td>
    <td>{{$f->sub_id}}</td>
    <td>{{$f->type}}</td>
  </tr>
 @endforeach

 </tbody>
 </table>
 </br>
 <table id="Table4"  class="table table-hover" style="font-size: small;font-family: Arial" >
  <tbody>
  <tr style="width: 20%"  class="danger">
       <td align="left">{!! Form::label('request_id','Request_ID') !!} </td>
       <td align="left">{!! Form::label('sub_id','Sub_ID') !!} </td>
       <td align="left">{!! Form::label('user_id','User ID') !!} </td>
       <td align="left">{!! Form::label('user_name','User name') !!} </td>
       <td align="left">{!! Form::label('type','Type') !!} </td>


  </tr>

 <!--Get all requests made by pr -->
  @foreach($sf as $s)
  <tr>
     <td>{{$s->request_id}}</td>
     <td>{{$s->sub_id}}</td>
     <td>{{$s->user_id}}</td>
     <td>{{$s->user_name}}</td>
     <td>{{$s->type}}</td>

   </tr>
  @endforeach

  </tbody>
  </table>


 {!! Form::close() !!}


 {{--<script src="//code.jquery.com/jquery.js"></script>--}}
 {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}

 {{--</body>--}}
 @endsection



