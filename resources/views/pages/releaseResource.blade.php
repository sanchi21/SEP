@extends('...master')

@section('content')

<br>
<h2 style="color: #9A0000">Resource Release</h2>

<br>


<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home2" aria-controls="home" role="tab" data-toggle="tab">Project Resource</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Individual Resource</a></li>

  </ul>
  <br>

  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home2">

      <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
      <tbody>



                  <tr id="headRow" style="background-color: #e7e7e7">
                  <th width="10%">Project Code</th>
                  <th width="20%">Inventory Code</th>
                  <th width="40%">Type</th>
                  <th width="20%">Required Upto</th>
                  <th></th>

       @foreach($allocated as $all)

          <tr>


              {!! Form ::open(['method' => 'POST', 'url' => 'releaseResourceProject']) !!}

                  @if($all->item=='')


                   <td>{{$all->project_id}}</td>
                   <td>{{$all->inventory_code}}</td>
                   <input type="hidden" class="form-control input-sm" value="{{$all->device_type}}" name="name">
                   <td>{{$all->device_type}}</td>


                  @else

                   <td>{{$all->project_id}}</td>
                   <td>{{$all->inventory_code}}</td>
                   <input type="hidden" class="form-control input-sm" value="{{$all->item}}" name="name">
                    <td>{{$all->item}}</td>



                   @endif

                     <input type="hidden" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}">
                     <td>{{$all->required_upto}}</td>
                   <td>
                      <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal1">
                          Release
                        </button>
                   </td>
                     <input type="hidden" value="{{$all->request_id}}" name="rid">
                     <input type="hidden" value="{{$all->sub_id}}" name="sid">
                     <input type="hidden" value="{{$all->inventory_code}}" name="inventory">

                          <!-- Modal -->
                              <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                    </div>
                                    <div class="modal-body">
                                      <p>Are you sure you want to release this resource?</p>
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

      <div role="tabpanel" class="tab-pane" id="profile">


          <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
          <tbody>



                      <tr id="headRow" style="background-color: #e7e7e7">
                      <th width="10%">Inventory Code</th>
                      <th width="20%">Type</th>
                      <th width="20%">Make</th>
                      <th width="20%">Model</th>
                      <th width="20%">Allocated To</th>
                      <th></th>


           @foreach($hardwares as $all)

              <tr>
                 {{--<td>{{$all->request_id}}</td>--}}
                 {{--<td>{{$all->sub_id}}</td>--}}

                  {!! Form ::open(['method' => 'POST', 'url' => 'releaseResourceEmployee']) !!}




                       <td>{{$all->inventory_code}}</td>
                       <td>{{$all->resource_type}}</td>
                       <td>{{$all->make}}</td>
                       <td>{{$all->model}}</td>
                       <td>{{$all->user_name}}</td>



                         <td>
                         <!-- Button trigger modal -->
                         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal2">
                           Release
                         </button>
                         </td>
                         <input type="hidden" value="{{$all->inventory_code}}" name="inventory">


                         <!-- Modal -->
                       <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                         <div class="modal-dialog" role="document">
                           <div class="modal-content">
                             <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                             </div>
                             <div class="modal-body">
                               <p>Are you sure you want to release this resource?</p>
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


    <br>

     <script>

                $('#myModal').on('shown.bs.modal', function () {
                $('#myInput').focus()
                })

                </script>



@stop