@extends('master')
@section('content')
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<?php $req=0  ?>

<div>
<table class="table table-hover" style="font-size: small;font-family: Arial ;width:30%">
<tbody>
@foreach($ids as $id)
    <form action="{{ URL::route('ViewRequests') }}" method="post">
    <tr>
       <td><p><b>Project : {{$id->project_id}}</b></p></td>

       <input type="hidden" value="{{$id->request_id}}" name="hid1">
       <input type="hidden" value="{{$id->project_id}}" name="hid2">
       {!! Form::token() !!}
       <td> {!! Form::submit('Requests',['class'=>'btn btn-primary form-control','name'=>'ViewRequests',]) !!}</td>

    </form>
    <form action="{{ URL::route('ViewAll') }}" method="post">

          <input type="hidden" value="{{$id->request_id}}" name="hid1">
           <input type="hidden" value="{{$id->project_id}}" name="hid2">
           {!! Form::token() !!}
           <td style="width: 40%"> {!! Form::submit('Allocations',['class'=>'btn btn-primary form-control','name'=>'ViewAllocation']) !!}</td>

    </tr>
        </form>
@endforeach
</tbody>
</table>
</div>


  <div style="float:left; width:50%">
         @if(Session::has('flash_av') || Session::has('flash_get') ||Session::has('flash_search') )
         {{--<input type="hidden" value="{{$request_id}}" name="hidr">--}}
          <table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial ;width:85%" >
              <tbody>
             @foreach($results as $result)
          <form action="{{ URL::route('ResourceAllocation') }}" method="post">

             @if($result->item == '')
               <tr>
                 <td><p style="color: darkred">Software</p></td>
               </tr>
               <tr>
                  <td>Sub ID</td>
                   <td>{{$result->sub_id}}</td>
               </tr>
               <tr>
                   <td>Device Type</td>
                   <td>{{$result->device_type}}</td>
               </tr>
               <tr>
                   <td>No_Of_Licence</td>
                   <td>{{$result->model}}</td>
               </tr>
               <tr>
                   <td>Additional Information</td>
                   <td>{{$result->additional_information}}</td>
               </tr>
               @if(Session::has('flash_get'))
               <tr>
                <td>Serial No</td>
                <td><input type="text" class="form-control" name="serial" id="serial" placeholder="Serial No"style="height: 30px " tabindex="1" value="{{$inventory_code}}" /></td>
               </tr>
               <tr>
                 <td>Assigned Date</td>
                 <td><div class="col-xs-2 col-md-2">
                                 <div id="datepicker_start" class="input-append">
                                     <input type="text" id="date" name="date" data-format="yyyy--MM-dd" placeholder="yyyy-mm-dd" style="height:30px;">
                                     <span class="add-on" style="height: 30px;">
                                     <i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                     </span>
                                 </div>
                                 <script type="text/javascript">
                                         $(function() {

                                             var nowDate = new Date();
                                             var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                                            $('#datepicker_start').datetimepicker({
                                                 pickTime: false,
                                                 startDate: today
                                            });
                                         });
                                     </script>
                                 </div></td>
               </tr>
               <tr>
                  <td>Remarks</td>
                  <td><input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks"  style="height: 30px "   tabindex="1" value="" /></td>
               </tr>
               @endif

             @else
                <tr>
                  <td><p style="color: darkred">Hardware</p></td>
                </tr>
                <tr>
                 <td>Sub ID</td>
                 <td>{{$result->sub_id}}</td>
                </tr>
                <tr>
                 <td>Item</td>
                 <td>{{$result->item}}</td>
                </tr>
                <tr>
                 <td>OS Version</td>
                 <td>{{$result->os_version}}</td>
                </tr>
                <tr>
                 <td>Additional Information</td>
                 <td>{{$result->additional_information}}</td>
                </tr>
              @if(Session::has('flash_get'))
                <tr>
                  <td>Serial No</td>
                  <td><input type="text" class="form-control" name="serial" id="serial" style="height: 30px "    placeholder="Serial No" tabindex="1" value="{{$inventory_code}}" /></td>
                </tr>
                <tr>
                  <td>Assigned Date</td>
                  <td><div class="col-xs-2 col-md-2">
                        <div id="datepicker_start" class="input-append">
                          <input type="text" id="date" name="date" data-format="yyyy-MM-dd" placeholder="yyyy-mm-dd" style="height:30px;">
                          <span class="add-on" style="height: 30px;">
                          <i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                          </span>
                        </div>
                        <script type="text/javascript">
                               $(function() {
                                 var nowDate = new Date();
                                 var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                                 $('#datepicker_start').datetimepicker({
                                     pickTime: false,
                                     startDate: today
                                             });
                                          });
                        </script>
                     </div></td>
                </tr>
                <tr>
                  <td>Remarks</td>
                  <td><input type="text area" class="form-control" name="remarks" id="remarks" style="height: 30px"  placeholder="Remarks" tabindex="1" value="" /></td>
                </tr>
              @endif


             @endif
          {{--<td> {!! Form::submit('Allocate',['class'=>'btn btn-primary form-control','name'=>'Allocate']) !!}</td>--}}
          <input type="hidden" value="{{$result->sub_id}}" name="hid3">
          <input type="hidden" value="{{$result->item}}" name="hid4">
          <input type="hidden" value="{{$result->os_version}}" name="hid5">
          <input type="hidden" value="{{$result->device_type}}" name="hid6">
          <input type="hidden" value="{{$result->model}}" name="hid7">
          <input type="hidden" value="{{$result->additional_information}}" name="hid8">
          <input type="hidden" value="{{$result->request_id}}" name="hidr">
          <?php $req = $result->request_id ?>

          <td> {!! Form::submit('Allocate',['class'=>'btn btn-primary form-control','name'=>'Allocate']) !!}</td>

          {!! Form::token() !!}
        </form>

             @endforeach

              </tbody>
              </table>

         {{--<table id="Table3"  class="table table-hover" style="font-size: small;font-family: Arial ;width:30%" >--}}
         {{--<tbody>--}}
         {{--@foreach($ftp_account as $ftp)--}}
         {{--<form action="{{ URL::route('ViewFtp') }}" method="post">--}}
         {{--<input type="hidden" value="{{$ftp->request_id}}" name="hid9">--}}
         {{--<input type="hidden" value="{{$ftp->sub_id}}" name="hid10">--}}
         {{--<tr>--}}
             {{--<td><p style="color: darkred">FTP Account</p></td>--}}
         {{--</tr>--}}
         {{--<tr>--}}
            {{--<td>Account {{$ftp->sub_id}}</td>--}}
            {{--<td><button type="submit" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Assign</button></td>--}}
         {{--</tr>--}}
         {{--{!! Form::token() !!}--}}
         {{--</form>--}}
 {{--@endforeach--}}
        {{--</tbody>--}}
        {{--</table>--}}

    @endif
  </div>



  <div style="float:right; width:50%">
   <p style="color: darkred"><b>RESOURCES</b></p>

 <table style="font-size: small;font-family: Arial ;width:50%">
 <form action="{{ URL::route('SearchResource') }}" method="post">
   <tr>
    <td>Resource Type</td>
    <td>
        <select class="form-control" name="resource_type" >
          <option>Hardware</option>
          <option>Software</option>
        </select>
    </td>
   </tr>
   <tr></tr>
   <tr>
    <td>Type</td>
    <td><input type="text" class="form-control" name="type" id="un" style="height: 30px "placeholder="Select Type" tabindex="1" value="" /></td>
    <input type="hidden" name="r1" value="{{$req}}">
    <td> {!! Form::submit('Search',['class'=>'btn btn-primary form-control','name'=>'search']) !!}</td>
   </tr>
      {!! Form::token() !!}
 </form>
 </table>
</br>

 <table class="table table-hover" style="font-size: small;font-family: Arial ;width:50%">
       @if(Session::has('flash_search') || Session::has('flash_get'))
         @foreach($hardware_types as $search)
         <form action="{{ URL::route('SendResource') }}" method="post">
         @if($search->type != '')
         <tr>
           <td>Serial No</td>
           <td> <label name="serialno"> {{$search->inventory_code}} </label></td>
            <input type="hidden" value="{{$search->inventory_code}}" name="hid11">
             <input type="hidden" name="r2" value="{{$req}}">
           <td> {!! Form::submit('+',['class'=>'btn btn-primary form-control','name'=>'ass']) !!}</td>
         </tr>
         <tr>
           <td>Type</td>
           <td><label name="Type"> {{$search->type}} </label></td>
         </tr>
         @endif
         {!! Form::token() !!}
         </form>

         @endforeach



         @foreach($hardware_types as $searchs)
         <form action="{{ URL::route('SendResource') }}" method="post">
         @if($searchs->name !='')
         <tr>
           <td>Serial No</td>
           <td> <label name="serialno"> {{$searchs->inventory_code}} </label></td>
           <input type="hidden" value="{{$searchs->inventory_code}}" name="hid11">
            <input type="hidden" name="r2" value="{{$req}}">
           <td> {!! Form::submit('+',['class'=>'btn btn-primary form-control','name'=>'ass']) !!}</td>
         </tr>
         <tr>
           <td>Name</td>
           <td><label name="name"> {{$searchs->name}} </label></td>
         </tr>
         <tr>
           <td>No Of Licence</td>
           <td><label name="license"> {{$searchs->no_of_license}} </label></td>
         </tr>
         @endif
         {!! Form::token() !!}
         </form>
         @endforeach

       @endif
 </table>
 </div>






@endsection