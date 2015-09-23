@extends('master')

@section('content')

<br>


<h2 style=" color: #9A0000">Update Purchase</h2>

<br>


<div class="container">
{!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@updatePurchase'],'method'=>'POST')) !!}
              <div class="row">

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

              <div align="right">
                <button style="height: 36px" type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal2">Mark Purchased</button>
                <button style="max-width: 100px" type="button" class="btn btn-primary"  data-toggle="modal" data-target="#myModal1">Send Email</button>
              </div>



              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                             <div class="modal-dialog" role="document">
                                               <div class="modal-content">
                                                 <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                   <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                                 </div>
                                                 <div class="modal-body">
                                                   <p>Are you sure you want to update this Order?</p>
                                                 </div>
                                                 <div class="modal-footer">
                                                  <button type="submit" class="btn btn-primary">Yes</button>
                                                   <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                 </div>
                                               </div>
                                             </div>
                                             {!! Form::close() !!}
                                           </div>


          </div>

           <div class="container">

                          {!! Form::open(array('class'=>'form-horizontal','action' => ['PaymentController@sendEmail'],'method'=>'POST')) !!}
                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                             <div class="modal-dialog" role="document">
                               <div class="modal-content">
                                 <div class="modal-header">
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                   <h4 class="modal-title" id="myModalLabel">Message</h4>
                                 </div>
                                 <div class="modal-body">
                                   <textarea class="form-control" id="emailBody" name="emailBody"></textarea>
                                   <input type="hidden" value="{{$item->pRequest_no}}" name="reqID">
                                 </div>
                                 <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Send</button>
                                 </div>
                               </div>
                             </div>
                           </div>
                           {!! Form::close() !!}

                          </div>

          <br>




          @stop