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


                            <td>
                                   <input type="hidden" value="{{$all->request_id}}" name="rid">
                                   <input type="hidden" value="{{$all->sub_id}}" name="sid">

                          </td>
                          <td>
                          <div align="right">
                         <button style="height: 36px" type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal2">Send Request</button>
                         </div>


                          </td>


                          </tr>
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

                            </div>

                        {!! Form::close() !!}
                        @endforeach

                        </tbody>
                        </table>


</div>
@stop