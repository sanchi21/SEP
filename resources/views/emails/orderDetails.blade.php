

<br>
<br>
A new procument order has been placed!!
<br>
<br>
<h4>Request Number : {{$reqID}}</h4>

<br>
<h4>Order Date: {{$orderDate}}</h4>
<h4>Payment Method: {{$payMethod}}</h4>
<br>

------------------------------------------------------------------------------------------<br>
<h2>INVOICE</h2>
------------------------------------------------------------------------------------------<br>



<div class="container">

<table class="table table-hover" id="orderDetails" width="100%">
                          <thead>
                                  <tr id="headRow" style="background-color: #e7e7e7">

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
                                         <td>{{$item->vendor_id}}</td>
                                         <td>{{$item->item_no}}</td>
                                         <td>{{$item->description}}</td>
                                         <td>{{$item->quantity}}</td>
                                         <td>{{$item->price}}</td>
                                         <td>{{$item->price_tax}}</td>
                                         <td>{{$item->warranty}}</td>
                                         <input type="hidden" value="{{$item->pRequest_no}}" name="reqID">

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


<br>

<h3 style="float: Left"><strong>Total : Rs.{{$total}}</strong></h3>

<br>
<br>
------------------------------------------------------------------------------------------<br>
Click this link to update the purchase status : {{$link}}<br>
------------------------------------------------------------------------------------------<br>