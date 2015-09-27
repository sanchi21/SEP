
@extends('...master')

@section('content')
<br>
 @if($errors->any())
                  <div class="alert alert-danger" id="error_msg">
                     <ul style="list-style: none">
                     @foreach($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                     </ul>
                  </div>
                  @endif

<h2 style="color: #9A0000">Renewal</h2>
<div class="panel-body">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Renew Resources</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Pending Requests</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">



    <br>

                {!! Form ::open(['method' => 'POST', 'url' => 'searchResource']) !!}

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
                <th>Type</th>
                 <th>Project Code</th>
                <th>Assigned Date</th>
                <th>Required Upto</th>
                <th></th>


            {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@requestRenewal'],'method'=>'POST')) !!}

     @foreach($allocated as $all)

        <tr>

                @if($all->item=='')
                 <input type="hidden" class="form-control input-sm" value="{{$all->device_type}}" name="name[]">
                 <td>(S) {{$all->device_type}}</td>
                 <td>{{$all->project_id}}</td>
                 <td>{{$all->assigned_date}}
                 <input type="hidden" name="chkDate" value="{{$all->assigned_date}}">
                 </td>

                @else
                    <input type="hidden" class="form-control input-sm" value="{{$all->item}}" name="name">
                 <td>(H) {{$all->item}}</td>
                 <td>{{$all->project_id}}</td>
                 <td>{{$all->assigned_date}}
                 <input type="hidden" name="chkDate" value="{{$all->assigned_date}}">
                 </td>

                 @endif

                   <td><input type="date" name="req_upto[]" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}" style="width: 300px"></td>


                   <input type="hidden" value="{{$all->request_id}}" name="rid[]">
                   <input type="hidden" value="{{$all->sub_id}}" name="sid[]">

          </td>
          </tr>

        @endforeach

        </tbody>
        </table>

        <div align="right">
           <button style="height: 36px" type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal2">Send Requests</button>
           </div>

           <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want send the request</p>
                </div>
                <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Yes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>


    </div>
    <div role="tabpanel" class="tab-pane" id="profile">

      <br>

       <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
       <tbody>


                   <tr id="headRow" style="background-color: #e7e7e7">
                   <th>Name</th>
                   <th>Project Code</th>
                   <th>Requested Upto</th>
                   <th></th>

        @foreach($requests as $all)

           <tr>


               {!! Form ::open(['method' => 'POST', 'url' => 'cancelRenewal']) !!}




                    <td>{{$all->name}}</td>
                    <td>{{$all->project_id}}</td>

                    <td ><input type="date" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->req_upto}}" style="width: 300px" readonly></td>
                    <td>
                    <!-- Button trigger modal -->
                                         <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                           Cancel
                                         </button>
                    </td>
                      <input type="hidden" value="{{$all->id}}" name="reqID">
                      <input type="hidden" value="{{$all->sid}}" name="SubID">



                     <!-- Modal -->
                     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                       <div class="modal-dialog" role="document">
                         <div class="modal-content">
                           <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                             <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                           </div>
                           <div class="modal-body">
                             <p>Are you sure you want to cancel this request?</p>
                           </div>
                           <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Yes</button>
                             <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                           </div>
                         </div>
                       </div>
                     </div>

               {!! Form::close() !!}


             </td>
             </tr>

           @endforeach


           </tbody>
           </table>


    </div>

  </div>

</div>

            <script>

            $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
            })

            </script>


    @stop
