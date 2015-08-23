@extends('master')

@section('content')

<br>
<h2 style=" color: #9A0000">Update Orders</h2>

<br>
<br>

{!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@index'],'method'=>'POST')) !!}

          <div class="form-group">
                      <label class="col-md-2 control-label" for="cakeCategory">Orders</label>
                      <div class="col-md-4">
                        <select id="reqID" name="reqID" class="form-control">
                        <option value="">Select a Request Number</option>

                        @foreach($orders as $request)
                          <option value='{{$request->request_id}}'>{{$request->request_id}}</option>
                          @endforeach
                        </select>
                      </div>

                      <button type="submit" class="btn btn-primary">View</button>
          </div>

          {!! Form::close() !!}

          <br>
          <br>


          <div class="container">
                        <div class="row">



                            <br>
                                <table class="table table-hover" id="orderDetails" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                            <tr id="headRow" style="background-color: #e7e7e7">
                                              {{--<th width="60%">Request ID</th>--}}
                                              <th >Invoice ID</th>
                                              <th >Request ID</th>
                                              <th >Payment Method</th>
                                               <th>Ordered Date</th>
                                              <th >Total</th>
                                              <th></th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                    @foreach($orders as $item)

                                        <tr>
                                                   {{--<td>{{$item->pRequest_no}}</td>--}}
                                                   <td>{{$item->invoice_id}}</td>
                                                   <td>{{$item->request_id}}</td>
                                                   <td>{{$item->payment_method}}</td>
                                                   <td>{{$item->order_date}}</td>
                                                   <td>{{$item->total}}</td>

                                                    <td><a href="viewInvoice/{{$item->request_id}}"><button type="button">View Invoice</button></a></td>
                                                   {{--<input type="hidden" value="{{$item->request_id}}" name="reqID">--}}

                                        </tr>

                                        @endforeach

                                        <tr>
                                            <td>   </td>
                                            <td>   </td>
                                            <td>   </td>

                                        </tr>
                                    </tbody>
                                </table>


                        </div>
                    </div>

@stop