
@extends('...master')

@section('content')

<br>
<h2 style="color: #9A0000">Release Resource Requests</h2>

<br>

                {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@requestReleaseAdminSearch'],'method'=>'POST')) !!}

                <table  id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
                <tbody>

                        <td width="10%">Search</td>

                                <td width="25%">

                                <input type="text" class="form-control input-sm" name="searchKey" style="width: 300px">
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
               <th>Item Name</th>
               <th>Device Type</th>
               <th>Project Code</th>
               <th>Assigned Date</th>
               <th>Required Upto</th>
               <th></th>



    @foreach($requests as $all)
    {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@requestReleaseAdminPost'],'method'=>'POST')) !!}

       <tr>

                <td>{{$all->item_name}}</td>
                <td>{{$all->type}}</td>
                <td>{{$all->project_code}}</td>
                <td>{{$all->assigned_date}}</td>
                <td>{{$all->required_upto}}</td>

                <input type="hidden" value="{{$all->req_id}}" name="reqID">
                <input type="hidden" value="{{$all->sub_id}}" name="SubID">

                <td>
                <input class="btn btn-default" type="submit" name="accept" value="Accept">
                <input class="btn btn-danger" type="submit" name="reject" value="Reject">
                </td>


       </tr>

        {!! Form::close() !!}
      @endforeach


       </tbody>
       </table>




      </div>



    @stop