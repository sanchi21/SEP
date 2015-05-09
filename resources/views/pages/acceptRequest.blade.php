
@extends('master')

@section('content')

<br>
<h2 style="color: #9A0000">Renewal Requests</h2>

<br>
<br>


<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
   <tbody>


               <tr id="headRow" style="background-color: #e7e7e7">
               <th>Name</th>
               <th>Project Code</th>
               <th>Current Due Date</th>
               <th>Requested Upto</th>

    @foreach($requests as $all)

       <tr>

           {!! Form ::open(['method' => 'POST', 'url' => 'renewalAccept']) !!}


                <td>{{$all->name}}</td>
                <td>{{$all->project_id}}</td>

                <td><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}" style="width: 300px" readonly></td>
                <td><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->req_upto}}" style="width: 300px" readonly></td>
                <td> <input class="btn btn-default" type="submit" name="accept" value="Accept">
                <input class="btn btn-danger" type="submit" name="reject" value="Reject"></td>
                <input type="hidden" value="{{$all->id}}" name="reqID">
                <input type="hidden" value="{{$all->sid}}" name="SubID">

           {!! Form::close() !!}


         </td>
         </tr>

       @endforeach


       </tbody>
       </table>



    @stop