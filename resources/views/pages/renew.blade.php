
@extends('master')

@section('content')

<br>
<h2 style="color: #9A0000">Renew Resources</h2>


<br>

            {!! Form ::open(['method' => 'POST', 'url' => 'searchResource']) !!}

            <table class="table table-hover" id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
            <tbody>



                    <td style="width: 130px">Project Code</td>



                    <td style="width: 130px">
                            <select id="category" name="prCode" class="form-control input-sm" style="width: 250px">
                                @foreach($prCode as $pr)
                                    <option value='{{$pr->project_id}}'>{{ $pr->project_id }}</option>
                                @endforeach
                            </select>

                            <td style="width: 130px">



                            <input type="text" class="form-control input-sm" name="resourceName" style="width: 300px">
                            <td>
                            <button type="submit" name ="search" class="btn btn-primary" style="height: 30px;"><span class="glyphicon glyphicon-search"></span> </button>
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
            <th>Assigned Date</th>
            <th>Required Upto</th>



 @foreach($allocated as $all)

    <tr>
       {{--<td>{{$all->request_id}}</td>--}}
       {{--<td>{{$all->sub_id}}</td>--}}

        {!! Form ::open(['method' => 'POST', 'url' => 'requestRenewal']) !!}

            @if($all->item=='')

             <td><input type="text" class="form-control input-sm" value="{{$all->device_type}}" name="name" style="width: 300px" readonly></td>
             <td>{{$all->project_id}}</td>
             <td>{{$all->assigned_date}}</td>




            @else

             <td><input type="text" class="form-control input-sm" value="{{$all->item}}" name="name" style="width: 300px" readonly></td>
             <td>{{$all->project_id}}</td>
             <td>{{$all->assigned_date}}</td>




             @endif

               <td><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}" style="width: 300px"></td>
             <td> <input class="btn btn-default" type="submit" name="renewRequest" value="Request"></td>
               <input type="hidden" value="{{$all->request_id}}" name="rid">
               <input type="hidden" value="{{$all->sub_id}}" name="sid">

        {!! Form::close() !!}


      </td>
      </tr>

    @endforeach


    </tbody>
    </table>


   <br>
   <br>
   <br>



   <h2 style="color: #9A0000">Pending Renewal Requests</h2>
   <br>
   <br>


   <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
   <tbody>



               <tr id="headRow" style="background-color: #e7e7e7">
               <th>Name</th>
               <th>Project Code</th>
               <th>Requested Upto</th>

    @foreach($requests as $all)

       <tr>


           {!! Form ::open(['method' => 'POST', 'url' => 'cancelRenewal']) !!}




                <td>{{$all->name}}</td>
                <td>{{$all->project_id}}</td>



                  <td ><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->req_upto}}" style="width: 300px" readonly></td>
                <td> <input class="btn btn-danger" type="submit" name="cancelRequest" value="Cancel"></td>
                  <input type="hidden" value="{{$all->id}}" name="reqID">
                  <input type="hidden" value="{{$all->sid}}" name="SubID">

           {!! Form::close() !!}


         </td>
         </tr>

       @endforeach


       </tbody>
       </table>

    @stop