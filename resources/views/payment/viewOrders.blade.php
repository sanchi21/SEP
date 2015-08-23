@extends('master')

@section('content')

<br>
<div class="container">
<h2 style=" color: #9A0000">Update Orders</h2>

</div>


<br>
<br>



          <div class="form-group">
          <div class="container">
          {!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@searchOrders'],'method'=>'POST')) !!}

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

          </div>

          </div>



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