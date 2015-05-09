@extends('master')
@section('content')


<div style="float:left; width:50%">
<p style="color: darkred"><b>RESOURCE HSTORY</b></p>
<table style="font-size: small;font-family: Arial ;width:50%">
<form action="{{ URL::route('Track') }}" method="post">
  <tr>
    <td>Resource Type</td>
    <td>
        <select class="form-control" name="resource_type" >
          <option>Hardware</option>
          <option>Software</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Type</td>
    <td><input type="text" class="form-control" name="type" id="un" style="height: 30px "placeholder="Select Type" tabindex="1" value="" /></td>
    <td> {!! Form::submit('GO',['class'=>'btn btn-primary form-control','name'=>'go']) !!}</td>
   </tr>
      {!! Form::token() !!}
 </form>
 </table>
</br>

<table class="table table-hover" style="font-size: small;font-family: Arial ;width:70%">
       @if(Session::has('flash_search_resource'))
         @foreach($hardware_types as $search)
         <form action="{{ URL::route('FindHistory') }}" method="post">
         @if($search->type != '')
         <tr>
           <td>Serial No</td>
           <td> <label name="serialno"> {{$search->inventory_code}} </label></td>
            <input type="hidden" value="{{$search->inventory_code}}" name="hid_serial_code">
           <td> {!! Form::submit('History',['class'=>'btn btn-primary form-control','name'=>'ass']) !!}</td>
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
         <form action="{{ URL::route('FindHistory') }}" method="post">
         @if($searchs->name !='')
         <tr>
           <td>Serial No</td>
           <td> <label name="serialno"> {{$searchs->inventory_code}} </label></td>
           <input type="hidden" value="{{$searchs->inventory_code}}" name="hid_serial_code">
           <td> {!! Form::submit('History',['class'=>'btn btn-primary form-control','name'=>'ass']) !!}</td>
         </tr>
         <tr>
           <td>Name</td>
           <td><label name="name"> {{$searchs->name}} </label></td>
         </tr>
         @endif
         {!! Form::token() !!}
         </form>
         @endforeach

       @endif
 </table>
</div>




<div id="content" name="content" style="float:right; width:50%">
 @if(Session::has('flash_search_history'))
 <p style="color: darkred"><b>Resource Allocation History</b></p></br>
 <p style="color: #0044cc">Inventory code {{$get_serial_no}}</p>
 <table class="table table-hover" style="font-size: small;font-family: Arial ;width:70%">
  @foreach($history as $his)
  <tr>
   <td>Request Id</td>
   <td>{{$his->request_id}}</td>
  </tr>
  <tr>
   <td>Requested Date</td>
   <td>{{$his->required_from}}</td>
  </tr>
  <tr>
   <td>Assigned Date</td>
   <td>{{$his->assigned_date}}</td>
  </tr>
  <tr>
   <td>Released Date</td>
   <td>{{$his->required_upto}}</td>
  </tr>
  <tr>
   <td>Remarks</td>
   <td>{{$his->remarks}}</td>
  </tr>
  @endforeach

 </table>
  <input type="button" class="btn btn-primary form-control" value="Print" onclick="printAllocation('content')"></button>

 @endif

</div>

<script>
     function printAllocation(content){
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(content).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
</script>




@endsection