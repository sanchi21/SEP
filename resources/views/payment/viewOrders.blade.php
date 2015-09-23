@extends('master')

@section('content')

<br>

<h2 style=" color: #9A0000">Update Orders</h2>



<br>
<br>

          <div class="span12">

          <div class="well">
                  <div class="row">
          {!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@searchOrders'],'method'=>'POST')) !!}


                <div class="col-xs-4 col-md-2">
                    <label style="font-size: 18px">Search</label>
                </div>

                <div class="col-xs-4 col-md-4">
                    <input type="text" class="form-control input-sm" name="searchKey" style="width: 300px">
                    <button type="submit" name ="search" class="btn btn-primary" style="height: 30px;width: 30px"><span class="glyphicon glyphicon-search"></span> </button>
                </div>


        {!! Form ::close() !!}
                </div>

               </div>
          </div>

          <div class="span12">

                <br>
                    <table class="table table-hover" id="orderDetails" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                                <tr id="headRow" style="background-color: #e7e7e7">
                                  {{--<th width="60%">Request ID</th>--}}
                                  <th width="10%">Invoice ID</th>
                                  <th width="20%">Request ID</th>
                                  <th width="20%">Payment Method</th>
                                   <th width="20%">Ordered Date</th>
                                  <th width="10%">Total</th>
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

                                        <td><a href="viewInvoice/{{$item->request_id}}"><input type="button" name="edit" value="View Invoice" class="btn btn-primary" style="width: 120px;max-width: 120px"></a></td>
                                       {{--<input type="hidden" value="{{$item->request_id}}" name="reqID">--}}

                            </tr>

                            @endforeach

                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>

                            </tr>
                        </tbody>
                    </table>
          </div>

            <br><br><br><br><br>

@stop