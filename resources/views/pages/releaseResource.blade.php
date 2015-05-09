@extends('master')

@section('content')

<br>
<h2 style="color: #9A0000">Release Resources</h2>

<br>
<br>


<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
<tbody>



            <tr id="headRow" style="background-color: #e7e7e7">
            <th>Name</th>
            <th>Assigned Date</th>
            <th>Additional Info</th>
            <th>Required Upto</th>

 @foreach($allocated as $all)

    <tr>
       {{--<td>{{$all->request_id}}</td>--}}
       {{--<td>{{$all->sub_id}}</td>--}}

        {!! Form ::open(['method' => 'POST', 'url' => 'releaseResource']) !!}

            @if($all->item=='')

             <td><input type="text" class="form-control input-sm" value="{{$all->device_type}}" name="name" style="width: 300px" readonly></td>
             <td>{{$all->assigned_date}}</td>
             <td>{{$all->additional_information}}</td>



            @else

             <td><input type="text" class="form-control input-sm" value="{{$all->item}}" name="name" style="width: 300px" readonly></td>
             <td>{{$all->assigned_date}}</td>
             <td>{{$all->additional_information}}</td>



             @endif

               <td><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}" style="width: 300px" readonly></td>
             <td> <input class="btn btn-danger" type="submit" name="release" value="Release"></td>
               <input type="hidden" value="{{$all->request_id}}" name="rid">
               <input type="hidden" value="{{$all->sub_id}}" name="sid">

        {!! Form::close() !!}


      </td>
      </tr>

    @endforeach


    </tbody>
    </table>

@stop