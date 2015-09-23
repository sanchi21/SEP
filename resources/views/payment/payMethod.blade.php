@extends('master')

@section('content')

<br>
<div class="span12">

<h2 style=" color: #9A0000">Order Details</h2>
<br>
<br>

{!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@viewByRequest'],'method'=>'POST')) !!}

      <div class="well">
              <div class="row">

                  <div class="col-xs-4 col-md-2">
                      <label style="font-size: 18px">Approved Request</label>
                  </div>

                  <div class="col-xs-4 col-md-4">
                    <select id="reqID" name="reqID" class="form-control">
                    <option value=""> -- Select Request Number -- </option>
                    @foreach($requests as $request)
                      <option value='{{$request->pRequest_no}}'>{{$request->pRequest_no}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-xs-4 col-md-2">
                      <button type="submit" class="btn btn-primary">View</button>
                  </div>
            </div>
      </div>

      {!! Form::close() !!}

</div>


<br>
<br>


<!-- Select Basic -->




      <div class="container">
          <div class="row">

              <h3>Approved Items for Request No : {{$reqID}}</h3>

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
                              <td>   </td>
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
                <div class="panel-heading">
                <h3>Place Order</h3>
                </div>
                <div class="panel-body">
                <br>
                <br>

                <table width="100%">
                    <tr>
                        <td width="30%">
                            <label style="font-size: 18px">Payment Method</label>
                        </td>
                        <td>
                            <select id="payMethod" name="payMethod" class="form-control" style="width: 300px">
                              <option value="cash">Cash</option>
                              <option value="cheque">Cheque</option>
                            </select>
                        </td>
                        <td></td>
                    </tr>

                    <tr><td><br></td><td><br></td></tr>

                    <tr>
                        <td width="30%">
                            <label style="font-size: 18px">Cheque Number</label>
                        </td>
                        <td>
                            <input type="text" id="chequeNumber" name="chequeNumber" class="form-control input-sm"  style="width: 300px" disabled>
                        </td>
                        <td></td>
                    </tr>

                    <tr><td><br></td><td><br></td></tr>

                    <tr>
                        <td width="30%">
                            <label style="font-size: 18px">Order Date</label>
                        </td>
                        <td>
                            <input type="date" name="orderDate" data-format="MM-dd-yyyy" placeholder="mm-dd-yyyy" class="form-control input-sm"  style="width: 300px">
                        </td>
                        <td></td>
                    </tr>

                    <tr><td><br></td><td><br></td></tr>

                    <tr>
                        <td width="30%">
                            <label style="font-size: 18px">Description</label>
                        </td>
                        <td>
                            <textarea class="form-control" id="payDescription" name="payDescription" style="width: 300px;height: 90px"></textarea>
                        </td>

                        <td align="right">
                            <button style="height: 36px; max-width: 120px; width: 100px" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal2">Order</button>
                        </td>
                    </tr>

                </table>


                </div>

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

      <script type="text/javascript">
        var mySelect = document.getElementById("payMethod");
        mySelect.onchange = function () {
        document.getElementById("chequeNumber").disabled = this.value != "cheque";
             }
      </script>

      </div>






@stop