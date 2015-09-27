@extends('...master')

@section('content')

<h2 style="color: #9A0000">Request Release</h2>
<div class="panel-body">
<br>

                {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@requestReleaseSearch'],'method'=>'POST')) !!}

                <table  id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
                <tbody>

                        <td width="10%">Search</td>

                                <td width="25%">

                                <input type="text" class="form-control input-sm" name="searchKey" style="width: 300px">
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
                                <th>Item</th>
                                <th>Type</th>
                                 <th>Project Code</th>
                                <th>Assigned Date</th>
                                <th>Required Upto</th>
                                <th></th>
                                <th></th>

                     @foreach($allocated as $all)
                            {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@requestReleasePost'],'method'=>'POST')) !!}
                            <tr>


                                 <td> {{$all->item}}</td>
                                 <input type="hidden" value="{{$all->item}}" name="item">
                                 <td>(S) {{$all->device_type}}</td>
                                 <input type="hidden" value="{{$all->device_type}}" name="type">
                                 <td>{{$all->project_id}}</td>
                                 <input type="hidden" value="{{$all->project_id}}" name="pID">
                                 <td>{{$all->assigned_date}}
                                 <input type="hidden" value="{{$all->assigned_date}}" name="assigned_date">
                                 <td>{{$all->required_upto}}</td>
                                 <input type="hidden" value="{{$all->required_upto}}" name="reqUpto">


                                   <input type="hidden" value="{{$all->request_id}}" name="rid">
                                   <input type="hidden" value="{{$all->sub_id}}" name="sid">

                                   <td>
                                       <input class="btn btn-default" type="submit" name="accept" value="Request">
                                   </td>

                            </tr>

                            {!! Form::close() !!}

                        @endforeach

                        </tbody>
                        </table>


</div>
@stop