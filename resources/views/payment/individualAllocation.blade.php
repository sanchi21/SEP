@extends('master')

@section('content')

<br>
<h2 style="color: #9A0000">Individual Allocation</h2>

<br>

{{--{{$hardwares->inventory_code }}--}}
<div class="panel-body">
{!! Form ::open(['method' => 'POST', 'url' => 'searchHardware']) !!}

<div class="well">
            <table  id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
            <tbody>

                    {{--<td style="width: 130px">--}}
                            {{--<select id="category" name="type" class="form-control input-sm" style="width: 250px">--}}
                                {{--@foreach($types as $type)--}}
                                    {{--<option value='{{$type->type}}'>{{ $type->type }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}

                            <td width="10%">Search</td>

                            <td width="25%">



                            <input type="text" class="form-control input-sm" name="make" style="width: 300px">
                            <td>
                            <button type="submit" name ="search" class="btn btn-primary" style="height: 30px;width: 30px"><span class="glyphicon glyphicon-search"></span> </button>
                            </td>



                            <td style="width: 130px"><a class="btn btn-default" name="Allocation" href="viewAllocations">View Allocations</a> </td>
                    </td>

            </tbody>
            </table>
            {!! Form ::close() !!}
</div>


        <table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tbody>


                    <tr id="headRow" style="background-color: #e7e7e7">
                    <th width="10%">Inventory Code</th>
                    <th width="30%">Type</th>
                    <th width="15%">Make</th>
                    <th width="15%">Model</th>
                    <th width="20%">Users</th>
                    <th></th>




         @foreach($hardwares as $hard)

         {!! Form ::open(['method' => 'POST', 'url' => 'employeeAllocation']) !!}

            <tr>

                     <td>{{$hard->inventory_code}}</td>
                     <td>{{$hard->type}}</td>
                     <td>{{$hard->make}}</td>
                     <td>{{$hard->model}}</td>
                     <td>
                     <select id="category" name="username" class="form-control input-sm" style="width: 250px">
                               @foreach($users as $user)
                                     <option value='{{$user->id}}'>{{ $user->username }}</option>
                               @endforeach
                     </select>
                     </td>


                     <td> <input class="btn btn-primary" type="submit" name="renewRequest" value="Allocate" style="height: 32px;width: 90px"></td>
                       <input type="hidden" value="{{$hard->inventory_code}}" name="inventory_code">

                {!! Form::close() !!}


              </td>
              </tr>

            @endforeach


            </tbody>
            </table>

</div>
@stop