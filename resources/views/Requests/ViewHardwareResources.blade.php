<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 23/8/2015
 * Time: 10:45 AM
 */
 ?>
 @extends('master')
 @section('content')

<h3><b>{{$inventoryType}}</b></h3>
<h4 style="color: #9A0000"><b>{{$inventory_code}}</b></h4>
</br>
<table class="table table-hover">

    <tr>
        <th>Project Code</th>
        <th>Request Id</th>
        <th>Inventory code</th>
        <th>Assigned Date</th>
        <th>Remarks</th>
        <th>Current Status</th>
    </tr>
     <?php $value=0  ?>
     @foreach($results as $result)

     <tr>
        <td>{{$projectCodes[$value]}}</td>
        <td>{{$result->request_id}}</td>
        <td>{{$result->inventory_code}}</td>
        <td>{{$result->assigned_date}}</td>
        <td>{{$result->remarks}}</td>
        <td>{{$result->status}}</td>
     </tr>

    <?php $value++  ?>
    @endforeach

</table>




@endsection