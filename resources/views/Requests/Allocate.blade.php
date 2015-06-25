@extends('master')
@section('content')
{{--<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">--}}

<style>
    .table-hover-l>tbody>tr>td
    {
        line-height: 0px solid #ddd;
        border-top: none;
    }
</style>

<?php $req=0  ?>

<h2 style="color: #9A0000">Resource Allocation</h2>

<div class="panel-body">
    <table class="table table-hover" width="100%">
        <tr style="background-color: #f5f5f5;">
            <th width="80%">Project&nbsp;Code</th>
            <th width="10%">Requests</th>
            <th width="10%">Allocation</th>
        </tr>
    <tbody>

        @foreach($ids as $id)
        <form action="{{ URL::route('ViewRequests') }}" method="post">
            <tr style="padding: 2px">
                <td><p><b>Project : {{$id->project_id}}</b></p></td>

                <input type="hidden" value="{{$id->request_id}}" name="hid1">
                <input type="hidden" value="{{$id->project_id}}" name="hid2">
                {!! Form::token() !!}
                <td> {!! Form::submit('View',['class'=>'btn btn-primary form-control','name'=>'ViewRequests']) !!}</td>

        </form>

        <form action="{{ URL::route('ViewAll') }}" method="post">

            <input type="hidden" value="{{$id->request_id}}" name="hid1">
            <input type="hidden" value="{{$id->project_id}}" name="hid2">
            {!! Form::token() !!}

            <td style="width: 40%"> {!! Form::submit('View',['class'=>'btn btn-primary form-control','name'=>'ViewAllocation']) !!}</td>

            </tr>
        </form>
        @endforeach
    </tbody>
    </table>
</div>

<div class="panel-body">


        @if(Session::has('flash_av') || Session::has('flash_get') ||Session::has('flash_search') )
        {{--<input type="hidden" value="{{$request_id}}" name="hidr">--}}

                 <div class="panel panel-default" style="width: 100%">
                    <div class="panel-heading" style="color: #9A0000"><h4>Requests</h4>
                    </div>

                 <div class="panel-body">

                    <table id="Table3"  class="table table-hover" style="width:100%;font-size: 14px">
                        <tr style="background-color: #f5f5f5;">
                            <th width="2%">Sub&nbsp;ID</th>
                            <th>Item</th>
                            <th>No of&nbsp;License</th>
                            <th>Additional&nbsp;Info</th>
                            <th>From</th>
                            <th>To</th>
                            @if(Session::has('flash_get'))
                            <th>Inventory&nbsp;Code</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Allocate</th>
                            @endif
                        </tr>
                        <tbody>
                 @foreach($results as $result)

                    <form action="{{ URL::route('ResourceAllocation') }}" method="post">
                        <input type="hidden" name="serial" value="{{$inventory_code}}">
                        @if($result->item == '')
                        {{--<tr>--}}
                        {{--<td><p style="color: darkred">Software</p></td>--}}
                            {{--</tr>--}}

                            <tr>
                                <td align="center"><label>{{$result->sub_id}}</label></td>
                                <td>(S)&nbsp;{{$result->device_type}}</td>
                                <td>{{$result->model}}</td>
                                <td>{{$result->additional_information}}</td>
                                <td>{{$result->required_from}}</td>
                                <td>{{$result->required_upto}}</td>


                            @if(Session::has('flash_get') && $result->sub_id == $sub)

                                    <td>{{$inventory_code}}</td>
                                <td>
                                        <div class="col-xs-2 col-md-2" style="margin-left: -15px">

                                        <div id="datepicker_start" class="input-append">
                                            <input type="text" id="date" name="date" data-format="yyyy--MM-dd" class="rounded" placeholder="yyyy-mm-dd" style="height:30px;width: 120px">
                                            <span class="add-on" style="height: 30px;">
                                            <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                        </div>

                                        <script type="text/javascript">
                                             $(function()
                                             {
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
                                    <td><input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks"  style="height: 30px "   tabindex="1" value="" /></td>

                            <td>
                                {!! Form::submit('&#10004;',['class'=>'btn btn-success form-control','name'=>'Allocate','style'=>'width:40px']) !!}
                            </td>
                            @endif
                            </tr>

                        @else
                {{--<tr>--}}
                  {{--<td><p style="color: darkred">Hardware</p></td>--}}
                {{--</tr>--}}
                                <tr>
                                    <td align="center"><label>{{$result->sub_id}}</label></td>
                                    <td>(H)&nbsp;{{$result->item}}</td>
                                    <td>{{$result->os_version}}</td>
                                    <td>{{$result->additional_information}}</td>
                                    <td>{{$result->required_from}}</td>
                                    <td>{{$result->required_upto}}</td>

                                @if(Session::has('flash_get') && $result->sub_id==$sub)

                                    <td>{{$inventory_code}}</td>

                                    <td>
                                        <div class="col-xs-2 col-md-2" style="margin-left: -15px">

                                            <div id="datepicker_start" class="input-append">
                                            <input type="text" id="date" name="date" class="rounded" data-format="yyyy-MM-dd" placeholder="yyyy-mm-dd" style="height:30px;width: 120px">
                                            <span class="add-on" style="height: 30px;">
                                            <i class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                            </span>
                                        </div>

                                        <script type="text/javascript">
                                            $(function()
                                            {
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
                                <td><input type="text area" class="form-control" name="remarks" id="remarks" style="height: 30px"  placeholder="Remarks" tabindex="1" value="" /></td>

                                <td>
                                    {!! Form::submit('&#10004;',['class'=>'btn btn-success form-control','name'=>'Allocate','style'=>'width:40px']) !!}
                                </td>
                                @endif
                                </tr>


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

                {!! Form::token() !!}
                    </form>

                 @endforeach
                    {{--</div>--}}
                </tbody>
                </table>
                </div>




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




    {{--<div style="float:right; width:50%">--}}

        <div class="panel panel-default" style="width: 100%">
            <div class="panel-heading" style="color: #9A0000"><h4>Available Resources</h4></div>

                <div class="panel-body">

                    <div class="well">
                        <table width="100%">
                            <form action="{{ URL::route('SearchResource') }}" method="post">
                                <tr>
                                    <td width="24%"><label>Resource&nbsp;Type</label></td>
                                    <td width="24%">
                                        <select class="form-control" name="resource_type" style="width: 160px">
                                            <option>Hardware</option>
                                            <option>Software</option>
                                        </select>
                                    </td>

                                    <td width="24%"><label>&nbsp;Type</label></td>
                                    <td width="24%"><input type="text" class="form-control" name="type" id="un" style="width: 160px" placeholder="Select Type" tabindex="1" value="" /></td>
                                        <input type="hidden" name="r1" value="{{$req}}">
                                    <td>
                                    {{--&nbsp;{!! Form::submit('S',['class'=>'btn btn-primary form-control','name'=>'search']) !!}--}}
                                        &nbsp;<button type="submit" class="btn btn-primary" style="height: 32px;" name="search"><span class="glyphicon glyphicon-search"></span> </button>
                                    </td>
                                </tr>
                            {!! Form::token() !!}
                            </form>
                        </table>
                </div>
                </br>

                <table class="table table-hover">

                @if(Session::has('flash_search') || Session::has('flash_get'))

                    @if($hardware_types[0]->name =='')
                        <tr style="background-color: #f5f5f5;">
                            <th width="15%">Serial&nbsp;No</th>
                            <th width="20%">Type</th>
                            <th width="10%">Make</th>
                            <th width="15%">OS</th>
                            <th width="10%">CPU</th>
                            <th width="10%">RAM</th>
                            <th width="10%">Harddisk</th>
                            <th width="5%">ID</th>
                            <th width="5%"></th>
                        </tr>
                    @endif


                    @foreach($hardware_types as $search)
                        <form action="{{ URL::route('SendResource') }}" method="post">
                        @if($search->type != '')
                            <tr>
                                {{--<td>Serial No</td>--}}
                                <td> <label name="serialno"> {{$search->inventory_code}} </label></td>
                                <input type="hidden" value="{{$search->inventory_code}}" name="hid11">
                                <input type="hidden" name="r2" value="{{$req}}">

                                   {{--<td>Type</td>--}}
                                <td><label name="Type"> {{$search->type}} </label></td>
                                <td><label name="Type"> {{$search->make}} </label></td>
                                <td><label name="Type"> {{$search->OS}} </label></td>
                                <td><label name="Type"> {{$search->CPU}} </label></td>
                                <td><label name="Type"> {{$search->RAM}} </label></td>
                                <td><label name="Type"> {{$search->hard_disk}} </label></td>
                                <?php $rr=0 ?>
                                <td>
                                    <select class="form-control" style="padding: 0px 0px;height: 32px" name="sub">
                                    @foreach($results as $r)
                                        @if($r->item !='')
                                            <option value="{{$r->sub_id}}">{{$r->sub_id}}</option>
                                            <?php $rr++ ?>
                                        @endif
                                    @endforeach
                                    </select>
                                </td>
                                @if($rr!=0)
                                    <td> {!! Form::submit('+',['class'=>'btn btn-primary form-control','name'=>'ass','style'=>'width:34px']) !!}</td>
                                @else
                                    <td> {!! Form::submit('+',['class'=>'btn btn-default form-control','name'=>'ass','style'=>'width:34px','disabled'=>'true']) !!}</td>
                                @endif
                            </tr>
                        @endif
                        {!! Form::token() !!}
                        </form>

                    @endforeach

                    @if($hardware_types[0]->name !='')
                        <tr style="background-color: #f5f5f5;">
                            <th width="15%">Serial&nbsp;No</th>
                            <th width="50%">Name</th>
                            <th width="25%">No&nbsp;Of&nbsp;License</th>
                            <th width="5%">ID</th>
                            <th width="5%"></th>
                        </tr>
                    @endif

                    @foreach($hardware_types as $searchs)
                        <form action="{{ URL::route('SendResource') }}" method="post">
                        @if($searchs->name !='')
                            <tr>
                            {{--<td>Serial No</td>--}}
                                <td> <label name="serialno"> {{$searchs->inventory_code}} </label></td>
                                <input type="hidden" value="{{$searchs->inventory_code}}" name="hid11">
                                <input type="hidden" name="r2" value="{{$req}}">

                                {{--<td>Name</td>--}}
                                <td><label name="name"> {{$searchs->name}} </label></td>

                               {{--<td>No Of Licence</td>--}}
                                <td><label name="license"> {{$searchs->no_of_license}} </label></td>

                                <?php $rr=0 ?>
                                <td>
                                    <select class="form-control" style="padding: 0px 0px;height: 32px" name="sub">
                                        @foreach($results as $r)
                                            @if($r->item =='')
                                                <option value="{{$r->sub_id}}">{{$r->sub_id}}</option>
                                                <?php $rr++ ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                @if($rr!=0)
                                <td> {!! Form::submit('+',['class'=>'btn btn-primary form-control','name'=>'ass','style'=>'width:34px']) !!}</td>
                                @else
                                <td> {!! Form::submit('+',['class'=>'btn btn-default form-control','name'=>'ass','style'=>'width:34px','disabled'=>'true']) !!}</td>
                                @endif
                            </tr>
                        @endif
                        {!! Form::token() !!}
                        </form>
                    @endforeach

                @endif
                </table>
            </div>
        </div>

</div>



@endsection