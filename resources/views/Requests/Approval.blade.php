<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 2/8/2015
 * Time: 5:35 PM
 */
 ?>
@extends('master')
@section('content')


   <script type="text/javascript">
                $(document).ready(function() {
                    $('#user').multiselect({
                    enableFiltering: true,
                    buttonWidth: '350px'
                    });
                });
   </script>


<div class="panel panel-default" name="sss" style="width: 100%">

     
     <div class="panel-heading" style="color: #9A0000">
                <h4>Approval</h4>
     </div>


     <div class="panel-body">

        <table class="table table-hover" width="100%">

            <form action="{{ URL::route('ViewRequestsApp') }}" method="post">

                  <tr style="padding: 2px">
                  <td><select class="form-control" name="request_no">
                                <option>-- Select Procurement Request --</option>
                               @foreach($viewRequests as $request)
                                  <option>
                                      {{$request->pRequest_no}}
                                  </option>
                                @endforeach
                  </select></td>

            {!! Form::token() !!}
            <td> {!! Form::submit('View',['class'=>'btn btn-primary form-control','name'=>'ViewRequests']) !!}</td>

            </form>

        </table>
        </br>

        @if(Session::has('flash_viewApprovalRequests'))

        @if(($requestedItems != null) && ( $id !=null))

             <div >
                                        @if(Session::has('flash_message_savedChanges'))

                                           <div class="alert alert-success">
                                                {{Session::get('flash_message_savedChanges')}}
                                           </div>
                                        @endif

                                        <script>
                                               $('div.alert').delay(4000).slideUp(300);
                                        </script>
                                  </div>
                                  <div >
                                         @if(Session::has('flash_message_CancelModification'))
                                         @if(  !(Session::has('flash_message_savedChanges')) )
                                             <div class="alert alert-danger">
                                                  {{Session::get('flash_message_CancelModification')}}
                                             </div>
                                         @endif
                                         @endif
                                         <script>
                                              $('div.alert').delay(4000).slideUp(300);
                                         </script>
                                  </div>


            <div class="panel panel-default"  style="width: 100%">
                <div class="panel-body">

                 <?php $i=1; $j=1 ?>
                <h4>Procurement&nbsp;Request&nbsp;{{$id}}</h4>
                <h5 style="color: #9A0000">Status&nbsp;:&nbsp;{{$requestStatus}}</h5>

                </br><td width="20%"><label style="font-size: 16px;color: #9A0000 ">Edit</label></td>
                <td width="28%"> <input type="checkbox" name="test" value="a" /></td>
                <td><a href="/download/{{$id}}" class="btn btn-large pull-right"><i class="icon-download-alt"> </i> Download Attachment</a></td>

                <div id="tab-count">

                    <ul class="nav nav-tabs">
                    @foreach($vendors as $vendor)

                        <li @if($i==1) class="active" @endif><a href="#{{$vendor->vendor_id}}" data-toggle="tab">{{$vendor->vendor_id}}</a></li>
                        <?php $i++ ?>

                    @endforeach
                    </ul>

                    <div class="tab-content">

                        @foreach($vendors as $vendor)

                             <div @if($j==1) class="tab-pane active" @else class="tab-pane" @endif id="{{$vendor->vendor_id}}">

                             <form action="{{ URL::route('UpdateChanges') }}" method="post">

                                <input type="hidden" value="{{$vendor->vendor_id}}" name="vendor">

                                <table id="viewProcurementRequests" class="table table-hover" style="width:100%;font-size: 14px">
                                    <tr>

                                        <th>Vendor</th>
                                        <th>Item &nbsp;No</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total&nbsp;Price</th>
                                        <th>Price&nbsp;Tax</th>
                                        <th>Warranty</th>
                                    </tr>

                                    @foreach($requestedItems as $item)
                                    @if($item->vendor_id ==$vendor->vendor_id)
                                    <tr>

                                        <td> <label name="vendorId[]">{{$item->vendor_id}}</label></td>

                                        <td><label  name="itemNo[]">{{$item->item_no}}</label></td>

                                        <td><label  name="des[]">{{$item->description}}</label></td>

                                        <td><input type="number" min="0" class="a" name="quantity[]" id="quantity[]"style="height: 30px; -webkit-border-radius: 5px;-moz-border-radius: 5px; border-radius: 5px;border: 1px solid #cccccc;" tabindex="1" value="{{$item->quantity}}" disabled="disabled"/></td>

                                        <td><label name="pri[]">{{$item->price}}</label></td>

                                        <td><label name="totalPrice[]">{{$item->total_price}}</label></td>

                                        <td><label  name="priceTaxs[]">{{$item->price_tax}}</label></td>

                                        <td><label name="warranty[]">{{$item->warranty}}</label></td>

                                        <input type="hidden" value="{{$item->pRequest_no}}" name="pRequest_no[]">
                                        <input type="hidden" value="{{$item->pRequest_no}}" name="pRequest_nos">
                                        <input type="hidden" value="{{$item->vendor_id}}" name="vendorId1[]">
                                        <input type="hidden" value="{{$item->item_no}}" name="itemNo1[]">
                                        <input type="hidden" value="{{$item->description}}" name="description[]">
                                        <input type="hidden" value="{{$item->price}}" name="price[]">
                                        <input type="hidden" value="{{$item->price}}" name="priceTax[]">

                                    </tr>
                                    @endif
                                    @endforeach


                                </table>

                                <input type="hidden" id ="countProcurementRequests" name="countProcurementRequests">


                                <table>

                                    <tr>
                                        <td>
                                            {!! Form::submit('Save',['class'=>'btn btn-success form-control','name'=>'save','onClick'=>'getRow_Approval()'] )!!}
                                        </td>

                                        <td>
                                            {!! Form::submit('cancel',['class'=>'btn btn-danger form-control','name'=>'cancel','onClick' => 'popupCancel()'] )!!}
                                            <input type="hidden" id ="valueApprovalCancel" name="valueApprovalCancel">
                                        </td>

                                    </tr>
                                </table>

                             {!! Form::token() !!}
                             </form>

                             </div>

                             <?php $j++ ?>

                        @endforeach
                    </div>
                </div>
                </div>
            </div><br>
        @endif
        @endif

        <table class="table table-hover" width="100%">
        <form action="{{ URL::route('ApproveRequest') }}" method="post">
              <tr>
                    <th width="25%">Note</th>
                    @if(Session::has('flash_viewApprovalRequests') ||Session::has('flash_message_CancelModification')||Session::has('flash_message_savedChanges'))
                     <th width="25%">vendor</th>
                    @endif
                    <th width="25%">Status</th>
                    <th width="25%">Approve For</th>
              </tr>

              <tr>

                  <td><textarea rows="10" cols="50" class="form-control" id="note" name="note" style="width: 80% ; height: 70px"></textarea></td>



                   @if(Session::has('flash_viewApprovalRequests') ||Session::has('flash_message_CancelModification')||Session::has('flash_message_savedChanges'))
                   <td>
                       <select class="form-control" style="padding: 0px 0px;height: 32px; width:80%" name="selectVendorId" id="selectVendorId">

                               <option>-- Select Vendor--</option>
                               <option>Select All</option>
                               @foreach($vendors as $vendor)
                                      <option>{{$vendor->vendor_id}}</option>

                               @endforeach

                       </select>
                        @foreach($vendors as $vendor)
                            <input type="hidden" id ="vendorsRequestNo" name="vendorsRequestNo" value="{{$vendor->pRequest_no}}">
                            <input type="hidden" id ="currentVendors[]" name="currentVendors[]" value="{{$vendor->vendor_id}}">
                        @endforeach
                   </td>
                   @endif



                  <td>
                      <select class="form-control" style="padding: 0px 0px;height: 32px; width:80%" name="status" >
                             <option>-- Status --</option>
                             @foreach($procurementStatus as $status)
                               <option>{{$status->status}}</option>
                             @endforeach

                      </select>
                  </td>

                  <td>
                      <select class="form-control" style="padding: 0px 0px;height: 32px; width:80%" name="email1" id="email1">
                               <option>--Approve--</option>
                               @foreach($users as $user)
                               <option>
                                       {{$user->username}}|{{$user->id}}
                               </option>
                               @endforeach

                      </select>
                  </td>

              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  @if(Session::has('flash_viewApprovalRequests') ||Session::has('flash_message_CancelModification')||Session::has('flash_message_savedChanges'))
                    <td></td>
                  @endif
                   <td>
                      <select  multiple="multiple" name="user[]" id="user">
                             @foreach($users as $user)
                              <option>
                                      {{$user->username}}|{{$user->id}}
                              </option>
                              @endforeach
                      </select>
                  </td>
              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  @if(Session::has('flash_viewApprovalRequests') ||Session::has('flash_message_CancelModification')||Session::has('flash_message_savedChanges'))
                    <td></td>
                  @endif
                  <td>
                       {!! Form::submit('Submit',['class'=>'btn btn-primary form-control','name'=>'submit']) !!}
                  </td>
              </tr>
        {!! Form::token() !!}
        </form>
        </table>

     </div>
</div>





<script>

  $(function () {
    $('#approvalTab a:first').tab('show')
  })



  var forms = document.forms['a'];
  $(forms).ready(function(){
  $('input[type=checkbox][name=test]').click(function(){
      var related_class=$(this).val();
      $('.'+related_class).prop('disabled',false);

   $('input[type=checkbox][name=test]').not(':checked').each(function(){
           var other_class=$(this).val();
           $('.'+other_class).prop('disabled',true);
       });

  });
  });

  function getRow_Approval(viewProcurementRequests){
           var x = document.getElementById("viewProcurementRequests").rows.length;
           document.getElementById("countProcurementRequests").value=x;

      }

  function popupCancel(){
       var r = confirm("Are sure that you want to cancel this ftp account request?");
              if (r == true) {
                  document.getElementById("valueApprovalCancel").value=true;
              } else {
                 document.getElementById("valueApprovalCancel").value=false;
              }
     }




</script>


@endsection