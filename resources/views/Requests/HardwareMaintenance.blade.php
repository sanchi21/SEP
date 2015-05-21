@extends('master')
@section('content')

{{--<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">--}}



<script type="text/javascript">
                $(document).ready(function() {
                    $('#hw').multiselect({
                    enableFiltering: true,
                    buttonWidth: '350px'
                    });
                });
</script>


{!! Form::open() !!}

<div style="float:left; width:50%">

<p></p></br>
<p style="color: darkred"><b>HARDWARE MAINTENANCE</b></p></br>

<table id="Table1"  class="table table-hover"style="font-size: small;font-family: Arial ;width:85%" >
<tbody>
<tr>
     <td>Hardware Inventory Code</td>
     <td><select id="hw" name="hw"  style="height:33px;width: 100%;margin-right: 0.2cm">
         @foreach($hardware as $hw)
         <option>
                {{$hw->inventory_code}}
         </option>
         @endforeach
     </select></td>
 </tr>
 <tr>
     <td>Remarks</td>
     <td><input type="text" class="form-control" name="remarks" id="remarks" style="height:30px;width:91%" placeholder="Remarks" tabindex="1" value="" /></td>
 </tr>
 <tr>
     <td>Date</td>
     <td><div class="col-xs-2 col-md-2">
             <div id="datepicker_start" class="input-append">
                 <input type="text" id="date" name="date" data-format="yyyy--MM-dd" class="rounded" placeholder="yyyy-mm-dd" style="height:30px;width:310px">
                 <span class="add-on" style="height: 30px;">
                 <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
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
         </div>
     </td>
 </tr>
 <tr>
     <td>Cost</td>
     <td><input type="text" class="form-control" name="cost" id="cost" style="height:30px;width:91%" placeholder="Cost" tabindex="1" value="" /></td>
 </tr>

 <tr>
     <td>{!! Form::submit('Save',['class'=>'sbtn','name'=>'save']) !!}</td>
 </tr>

</tbody>
</table>
<p></p></br>


</div>


<div style="float:right; width:50%">
<p></p></br>
<p style="color: darkred"><b>TOTAL MAINTENANCE COST</b></p></br>
{!! Form::submit('Check',['class'=>'sbtn','name'=>'view']) !!}
<p></p></br>

@if(Session::has('flash_total_c'))
<table class="table table-hover"style="font-size: small;font-family: Arial ;width:85%">
@foreach($finds as $fin)
<tr>
    <td>Remarks</td>
    <td>{{$fin->remarks}}</td>
    <td></td>
</tr>
<tr>
    <td>Date</td>
    <td>{{$fin->date}}</td>
    <td></td>
</tr>
<tr class="info">
    <td><b>Cost</b></td>
    <td> </td>
    <td><b>Rs  {{$fin->cost}}.00</b></td>
</tr>

@endforeach
<tr>
 <td></td>
</tr>
<tr class="danger">
    <td><p style="color: darkred"><b>Total</b></p></td>
    <td></td>
    <td><p style="color: darkred"><b>Rs {{$total_cost}}.00</b></p></td>
</tr>
</table>
@endif

</div>

{!! Form::close() !!}
@endsection