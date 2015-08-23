@extends('master')

@section('content')

<br>
<h2 style=" color: #9A0000">Order Details</h2>

<br>
<br>


 <!-- Select Basic -->
        {!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@viewByRequest'],'method'=>'POST')) !!}

          <div class="form-group">
                      <label class="col-md-2 control-label" for="cakeCategory">Approved Requests</label>
                      <div class="col-md-4">
                        <select id="reqID" name="reqID" class="form-control">
                        <option value="">Select a Request Number</option>
                        @foreach($requests as $request)
                          <option value='{{$request->pRequest_no}}'>{{$request->pRequest_no}}</option>
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

                  <h3>Approved Items for Request : {{$reqID}}</h3>

                  <br>
                      <table class="table table-hover" id="orderDetails" cellpadding="0" cellspacing="0" width="100%">
                          <thead>
                                  <tr id="headRow" style="background-color: #e7e7e7">
                                    {{--<th width="60%">Request ID</th>--}}
                                    <th >Vendor ID</th>
                                    <th >Item No</th>
                                    <th width="22%">Description</th>
                                     <th>Quantity</th>
                                    <th >Price</th>
                                    <th>Price Tax</th>
                                    <th>Warranty</th>
                                    <th></th>
                              </tr>
                          </thead>


                          <tbody>

                          @foreach($items as $item)

                              <tr>
                                         {{--<td>{{$item->pRequest_no}}</td>--}}
                                         <td>{{$item->vendor_id}}</td>
                                         <td>{{$item->item_no}}</td>
                                         <td>{{$item->description}}</td>
                                         <td>{{$item->quantity}}</td>
                                         <td>{{$item->price}}</td>
                                         <td>{{$item->price_tax}}</td>
                                         <td>{{$item->warranty}}</td>
                                         <input type="hidden" value="{{$item->pRequest_no}}" name="reqID">
                                         <input type="hidden" value="{{$item->item_no}}" name="item_no[]">
                              </tr>

                              @endforeach

                              <tr>
                                  <td>   </td>
                                  <td>   </td>
                                  <td>   </td>

                              </tr>
                          </tbody>
                      </table>

                     <h3 style="float: right"><strong>Total : Rs.{{$total->sum}}</strong></h3>



              </div>
          </div>

          <div class="container">
          {!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@placeOrder'],'method'=>'POST')) !!}
            <input type="hidden" value="{{$reqID}}" name="reqID">
            <input type="hidden" value="{{$total->sum}}" name="total">

          <div class="panel panel-default">
                    <div class="panel-body">
                    <h2>Place Order</h2>
                    </div>
                    <div class="panel-footer">
                    <br>
                    <br>

             <div class="form-group">
                      <label class="col-md-4 control-label" for="payMethod">Payment Method</label>
                      <div class="col-md-6">
                        <select id="payMethod" name="payMethod" class="form-control">
                          <option>Cash</option>
                          <option>Cheque</option>
                        </select>
                        <br>
                      </div>


                      </div>

                      <div class="form-group">
                    <label class="col-md-4 control-label" for="orderDate">Order Date</label>

                    <input type="date" name="orderDate" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm"  style="width: 300px">
                    </div>
                    <br>
                    <br>

                    </div>

                    <button style="float: right" type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal2">Order</button>

                    <!-- Modal -->
                   <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                     <div class="modal-dialog" role="document">
                       <div class="modal-content">
                         <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                         </div>
                         <div class="modal-body">
                           <p>Are you sure you want to place an order for this request?</p>
                         </div>
                         <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Yes</button>
                           <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                         </div>
                       </div>
                     </div>
                   </div>

                    {!! Form::close() !!}

                  </div>


          </div>




@stop