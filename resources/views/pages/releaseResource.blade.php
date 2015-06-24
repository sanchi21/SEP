@extends('master')

@section('content')

<br>
<h2 style="color: #9A0000">Project Resource Release</h2>

<br>
<br>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home2" aria-controls="home" role="tab" data-toggle="tab">Project Resource Release</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Individual Resource Release</a></li>

  </ul>

  <br>
  <br>

  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home2">

      <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
      <tbody>



                  <tr id="headRow" style="background-color: #e7e7e7">
                  <th>Project Code</th>
                  <th>Inventory Code</th>
                  <th>Name</th>
                  <th>Required Upto</th>

       @foreach($allocated as $all)

          <tr>
             {{--<td>{{$all->request_id}}</td>--}}
             {{--<td>{{$all->sub_id}}</td>--}}

              {!! Form ::open(['method' => 'POST', 'url' => 'releaseResourceProject']) !!}

                  @if($all->item=='')


                   <td>{{$all->project_id}}</td>
                   <td>{{$all->inventory_code}}</td>
                   <td><input type="text" class="form-control input-sm" value="{{$all->device_type}}" name="name" style="width: 300px" readonly></td>


                  @else

                   <td>{{$all->project_id}}</td>
                   <td>{{$all->inventory_code}}</td>
                   <td><input type="text" class="form-control input-sm" value="{{$all->item}}" name="name" style="width: 300px" readonly></td>




                   @endif

                     <td><input type="text" name="req_upto" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm" value="{{$all->required_upto}}" style="width: 300px" readonly></td>
                   <td> <input class="btn btn-danger" type="submit" name="release" value="Release"></td>
                     <input type="hidden" value="{{$all->request_id}}" name="rid">
                     <input type="hidden" value="{{$all->sub_id}}" name="sid">
                     <input type="hidden" value="{{$all->inventory_code}}" name="inventory">

              {!! Form::close() !!}


            </td>
            </tr>

          @endforeach


          </tbody>
          </table>

      </div>

      <div role="tabpanel" class="tab-pane active" id="profile">

      <h2 style="color: #9A0000">Individual Resource Release</h2>

          <br>
          <br>


          <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
          <tbody>



                      <tr id="headRow" style="background-color: #e7e7e7">
                      <th>Inventory Code</th>
                      <th>Type</th>
                      <th>Make</th>
                      <th>Model</th>
                      <th>Allocated To</th>


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



                         <td> <input class="btn btn-danger" type="submit" name="release" value="Release"></td>
                         <input type="hidden" value="{{$all->inventory_code}}" name="inventory">

                  {!! Form::close() !!}


                </td>
                </tr>

              @endforeach


              </tbody>
              </table>


      </div>

   </div>





    <br>



@stop