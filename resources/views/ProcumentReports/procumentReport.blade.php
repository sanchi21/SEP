@extends('...master')

@section('content')

<h2 style="color: #9A0000">Procurement Reports</h2>

<br>

<div class="panel-body">

<table class="table table-hover" id="reportType" cellpadding="0" cellspacing="0" width="100%">
   <tbody>

   <tr id="headRow" style="background-color: #e7e7e7">

            <td>Report Type</td>
            <td>
                <select id="action" name="action" class="form-control" style= "width: 200px"  onchange="javascript:location.href = this.value;">
                      <option value="requestVendorReports" @if(Request::path() == 'requestVendorReports')selected @endif>Request With Vendor</option>
                      <option value="acceptedRequestReports" @if(Request::path() == 'acceptedRequestReports')selected @endif >Accepted Request</option>
                      <option value="orderReports" @if(Request::path() == 'orderReports')selected @endif >Orders</option>
                </select>
            </td>

            <td>

            @if(isset($vendors))
            {!! Form::open(array('class'=>'form-horizontal','action' => ['ProcumentReport@requestVendorReportsPost'],'method'=>'POST')) !!}
            <select id="action" name="sortBy" class="form-control" style= "width: 200px">
                  <option value="pRequest_no">Request ID</option>
                  <option value="vendor_name">Vendor Name</option>
                  <option value="status">Request Status</option>
            </select>
             <td>
            <button type="submit" name ="sort" class="btn btn-primary" style="height: 30px;width: 60px">SORT </button>
            </td>
            {!! Form ::close() !!}
            @endif

            @if(isset($pRequests))
            {!! Form::open(array('class'=>'form-horizontal','action' => ['ProcumentReport@acceptedRequestReportsPost'],'method'=>'POST')) !!}
            <select id="action" name="sortBy" class="form-control" style= "width: 200px">
                  <option value="pRequest_no">Request ID</option>
                  <option value="vendor_name">Vendor Name</option>
                  <option value="price_tax">Price</option>
            </select>
            <td>
            <button type="submit" name ="sort" class="btn btn-primary" style="height: 30px;width: 60px">SORT </button>
            </td>
            {!! Form ::close() !!}
            @endif

            @if(isset($orders))
            {!! Form::open(array('class'=>'form-horizontal','action' => ['ProcumentReport@orderReportsPost'],'method'=>'POST')) !!}
            <select id="action" name="sortBy" class="form-control" style= "width: 200px">
                  <option value="request_id">Request ID</option>
                  <option value="payment_method">Pay Method</option>
                  <option value="total">Total</option>
                  <option value="order_date">Ordered Date</option>
                  <option value="status">Order Status</option>
            </select>
            <td>
            <button type="submit" name ="sort" class="btn btn-primary" style="height: 30px;width: 60px">SORT </button>
            </td>
            {!! Form ::close() !!}
            @endif





   </tr>

   </tbody>

   </table>

        <div name = "report-header">
           <table width="100%">
               <tr>
                   <td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>
                   <td width="50%"></td>
               </tr>
               <tr>
                   <td width="50%"><h4>Zone24x7 (Private) Limited</h4></td>
                   <td width="50%" align="right"><h4>Date : {{date("d-m-Y")}}</h4></td>
               </tr>

               <tr>
                   <td width="50%"><h4>Nawala Road,</h4></td>
                   <td></td>
               </tr>

               <tr>
                   <td width="50%"><h4>Koswatte,</h4></td>
                   <td></td>
               </tr>

               <tr>
                   <td width="50%"><h4>Sri Lanka 10107</h4></td>
                   <td></td>
               </tr>

           </table>

            @if(isset($vendors))
           <h2 align="center">Vendor Details For Requests</h2>
           <br>
           @endif

           @if(isset($pRequests))
           <h2 align="center">Accepted Procurement Requests</h2>
           <br>
           @endif

           @if(isset($orders))
           <h2 align="center">Procurement Orders</h2>
           <br>
           @endif

       </div>

        @if(isset($vendors))


       <table class="table table-hover" id="vendorProcument" cellpadding="0" cellspacing="0" width="100%">
          <tbody>


                      <tr id="headRow" style="background-color: #e7e7e7">
                      <th>Request Number</th>
                      <th>Vendor Name</th>
                      <th>Vendor Address</th>
                      <th>Vendor Phone</th>
                      <th>Contact Email</th>
                      <th>Request Status</th>



           @foreach($vendors as $vendor)

              <tr>

                       <td>{{$vendor->pRequest_no}}</td>
                       <td>{{$vendor->vendor_name}}</td>
                       <td>{{$vendor->addrss}}</td>
                       <td>{{$vendor->phone}}</td>
                       <td>{{$vendor->email}}</td>
                       <td>{{$vendor->status}}</td>


                </td>
                </tr>

             @endforeach


              </tbody>
              </table>

              @endif


              @if(isset($pRequests))


                     <table class="table table-hover" id="vendorProcument" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>


                                    <tr id="headRow" style="background-color: #e7e7e7">
                                    <th>Request Number</th>
                                    <th>Vendor Name</th>
                                    <th>Item Number</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Warranty</th>
                                    <th></th>


                                    {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@adminAccept'],'method'=>'POST')) !!}

                         @foreach($pRequests as $pRequest)

                            <tr>

                                     <td>{{$pRequest->pRequest_no}}</td>
                                     <td>{{$pRequest->vendor_name}}</td>
                                     <td>{{$pRequest->item_no}}</td>
                                     <td>{{$pRequest->description}}</td>
                                     <td>{{$pRequest->quantity}}</td>
                                     <td>{{$pRequest->price_tax}}</td>
                                     <td>{{$pRequest->warranty}}</td>


                              </td>
                              </tr>

                           @endforeach


                            </tbody>
                            </table>

               @endif


        @if(isset($orders))


                <table class="table table-hover" id="vendorProcument" cellpadding="0" cellspacing="0" width="100%">
                   <tbody>


                               <tr id="headRow" style="background-color: #e7e7e7">
                               <th>Invoice ID</th>
                               <th>Request ID</th>
                               <th>Payment Method</th>
                               <th>Cheque Number</th>
                               <th>Total</th>
                               <th>Ordered Date</th>
                               <th>Description</th>
                               <th>Order Status</th>
                               <th></th>


                               {!! Form::open(array('class'=>'form-horizontal','action' => ['RenewalController@adminAccept'],'method'=>'POST')) !!}

                    @foreach($orders as $order)

                       <tr>

                                <td>{{$order->invoice_id}}</td>
                                <td>{{$order->request_id}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td>{{$order->cheque_number}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->order_date}}</td>
                                <td>{{$order->pay_description}}</td>
                                <td>{{$order->status}}</td>


                         </td>
                         </tr>

                      @endforeach


                       </tbody>
                       </table>

         @endif



</div>


@stop