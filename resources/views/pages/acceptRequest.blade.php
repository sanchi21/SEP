
@extends('...master')

@section('content')

<br>
<h2 style="color: #9A0000">Renewal Requests</h2>

<br>

                {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@adminSearchView'],'method'=>'POST')) !!}

                <table  id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
                <tbody>

                        <td width="10%">Search</td>

                                <td width="25%">

                                <input type="text" class="form-control input-sm" name="name" style="width: 300px">
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

               {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@adminAccept'],'method'=>'POST')) !!}

    @foreach($requests as $all)

       <tr>

                <td>{{$all->name}}</td>
                <td>{{$all->project_id}}</td>
                <input type="hidden" name="req_upto" class="form-control input-sm" value="{{$all->required_upto}}">
                <td>{{$all->required_upto}}</td>
                <input type="hidden" name="req_upto" class="form-control input-sm" value="{{$all->req_upto}}">
                <td>{{$all->req_upto}}</td>

                <td>
                    <select id="action" name="action[]" class="form-control" style="width: 250px">
                          <option value="accept">Accept</option>
                          <option value="reject">Reject</option>
                    </select>
                </td>
                {{--<td> <input class="btn btn-default" type="submit" name="accept" value="Accept">--}}
                {{--<input class="btn btn-danger" type="submit" name="reject" value="Reject"></td>--}}
                <input type="hidden" value="{{$all->id}}" name="reqID[]">
                <input type="hidden" value="{{$all->sid}}" name="SubID[]">


         </td>
         </tr>

      @endforeach


       </tbody>
       </table>

       <div align="right">
       <button style="height: 36px" type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal2">Update</button>
       </div>

       <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to update these actions?</p>
            </div>
            <div class="modal-footer">
             <button type="submit" class="btn btn-primary">Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>



    @stop