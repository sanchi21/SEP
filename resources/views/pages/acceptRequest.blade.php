
@extends('...master')

@section('content')

<br>
<h2 style="color: #9A0000">Renewal Requests</h2>

<br>

                {!! Form ::open(['method' => 'POST', 'url' => 'searchRequestsAdmin']) !!}

                <table  id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
                <tbody>

                        <td width="10%">Search</td>

                                <td width="25%">

                                <input type="text" class="form-control input-sm" name="resourceName" style="width: 300px">
                                <td>
                                <button type="submit" name ="search" class="btn btn-primary" style="height: 30px;width: 30px"><span class="glyphicon glyphicon-search"></span> </button>
                                </td>


                                </td>
                        </td>

                </tbody>
                </table>

                {!! Form ::close() !!}

                <br>


<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
   <tbody>


               <tr id="headRow" style="background-color: #e7e7e7">
               <th>Name</th>
               <th>Project Code</th>
               <th>Current Due Date</th>
               <th>Requested Upto</th>
               <th></th>

    @foreach($requests as $all)

       <tr>

           {!! Form ::open(['method' => 'POST', 'url' => 'renewalAccept']) !!}


                <td>{{$all->name}}</td>
                <td>{{$all->project_id}}</td>
                <input type="hidden" name="req_upto" class="form-control input-sm" value="{{$all->required_upto}}">
                <td>{{$all->required_upto}}</td>
                <input type="hidden" name="req_upto" class="form-control input-sm" value="{{$all->req_upto}}">
                <td>{{$all->req_upto}}</td>
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