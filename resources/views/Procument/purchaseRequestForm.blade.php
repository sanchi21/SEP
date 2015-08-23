
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}

.multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:120px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('#mail_cc').multiselect({
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>


<h2 style="color: #9A0000">Purchase Request</h2>
{{--<br>--}}
<br>
<div class="alert alert-danger" id="error_msg" style="display: none">
    <label id="msg"></label>
</div>
<div class="alert alert-success" id="success_msg" style="display: none">
    <label id="smsg"></label>
</div>

<div class="panel-body">
    <table width="100%">
        <tr>
            <td width="20%">
                <label>Purchase Request No</label>
            </td>
            <td width="25%">
                {{$requestNo}}
            </td>
            <td width="20%">
                <label>Date</label>
            </td>
            <td width="25%">
                {{date('d-m-Y')}}
            </td>
        </tr>
    </table>
</div>


<div id="tab-count">
<ul class="nav nav-tabs" role="tablist" id="myTab">

    @for($i=1 ; $i<=$noOfVendors ; $i++)
        <li role="presentation" @if($i==1) class="active" @endif><a href="#vendor{{$i}}" aria-controls="vendor{{$i}}" role="tab" data-toggle="tab">{{$i}}</a></li>
    @endfor
    {{--<li id="plus"><a onclick="newVendor()">+</a></li>--}}
</ul>
</div>
{!! Form ::open(['method' => 'POST', 'action' => ['PurchaseRequestController@store'], 'files' => 'true']) !!}

    <input type="hidden" name="request_no" value="{{$requestNo}}">
    <input type="hidden" id="tax" name="tax" value="{{$tax}}">
    <input type="hidden" id="no_of_vendors" name="no_of_vendors" value="{{$noOfVendors}}">

<div class="tab-content" id="mainTab">

@for($j=1 ; $j<=$noOfVendors ; $j++)
    <div role="tabpane{{$j}}" @if($j==1) class="tab-pane active" @else class="tab-pane" @endif id="vendor{{$j}}">

        <div class="well">
            <table width="100%">

            <tr>
                <td width="15%">
                    <label id="n2">Vendor ({{$j}})</label>
                </td>

                <td width="25%">
                    <select style="width: 250px" class="form-control input-sm" name="vendor_name[]">
                    @foreach($vendors as $vendor)
                        <option value="{{$vendor->vendor_id}}">
                            {{$vendor->vendor_name}}
                        </option>
                    @endforeach
                    </select>
                </td>

                <td>
                    <?php $name = "v$j" ?>
                    <input type="button" name="add" class="btn btn-primary form-control" value="+" style="width: 40px; height: 40px; font-size: 18px" onclick="addButton('{{$name}}')">
                    <input type="button" name="remove" class="btn btn-primary form-control" value="-" style="width: 40px; height: 40px; font-size: 18px" onclick="removeButton('{{$name}}')">
                </td>
            </tr>

            </table>
            <br>

            <table class="table table-hover" id="{{$name}}" name="{{$name}}[]" cellpadding="0" cellspacing="0" width="100%">
                <tr id="headRow" style="background-color: #e7e7e7">
                    <th style="width: 2%"></th>
                    <th style="width: 10%">Item</th>
                    <th style="width: 38%">Description</th>
                    <th style="width: 10%">Quantity</th>
                    <th style="width: 10%">Price</th>
                    <th style="width: 10%">Total&nbsp;Price</th>
                    <th style="width: 10%">Price&nbsp;+&nbsp;Tax</th>
                    <th style="width: 10%">Warranty</th>
                </tr>

                <tbody id="tableBody">
                <tr id="firstRow">
                    <td>
                        <input type='checkbox' class="form-control" style="height: 25px; width: 25px;"/>
                    </td>
                    <td>
                        <select class="form-control input-sm" name="item_{{$name}}[]" width="200px" >
                            <option value="Not Selected">Not Selected</option>
                            @foreach($pItems as $pItem)
                                <option value="{{$pItem->id}}">{{$pItem->item}}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="text" name="description_{{$name}}[]" class="form-control input-sm">
                        {{--{!!Form::text('description_'.$name.'[]','',['class'=>'form-control input-sm'])!!}--}}
                    </td>

                    <td>
                        <input type="number" name="quantity_{{$name}}[]" value="1" class="form-control input-sm" min="1" style="text-align: right">
                        {{--{!!Form::input('number','quantity_'.$name.'[]',1,['class'=>'form-control input-sm', 'min'=>'1'])!!}--}}
                    </td>

                    <td align="right">
                        <input type="text" name="price_{{$name}}[]" class="form-control input-sm" value="0.00" style="text-align: right">
                        {{--{!!Form::text('price_'.$name.'[]','',['class'=>'form-control input-sm'])!!}--}}
                    </td>

                    <td>
                        <input type="text" name="total_price_{{$name}}[]" class="form-control input-sm" style="text-align: right" disabled>
                        {{--{!!Form::text('total_price_'.$name.'[]','',['class'=>'form-control input-sm'])!!}--}}
                    </td>

                    <td>
                        <input type="text" name="tax_price_{{$name}}[]" class="form-control input-sm" style="text-align: right" disabled>
                        {{--{!!Form::text('tax_price_'.$name.'[]','',['class'=>'form-control input-sm'])!!}--}}
                    </td>

                    <td>
                        <input type="text" name="warranty_{{$name}}[]" class="form-control input-sm">
                        {{--{!!Form::text('warranty_'.$name.'[]','',['class'=>'form-control input-sm'])!!}--}}
                    </td>
                </tr>
                </tbody>

            </table>
        </div>

    </div>
@endfor

</div>


<div class="panel-body">
<table width="100%">
    <tr>
        <td width="20%"><label>Reason</label></td>
        <td width="80%"><input type="text" class="form-control" name="reason"></td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td width="20%">
            <label>For&nbsp;Approval</label>
        </td>
        <td width="30%">
            <select class="form-control" style="width: 300px" name="approval">
                <option value="1">Abhayan</option>
                <option value="2">Srinithy</option>
                <option value="3">Parthipan</option>
                <option value="4">Sanchayan</option>
            </select>
        </td>

        <td width="20%">
            <label>Mail&nbsp;CC</label>
        </td>
        <td width="30%">
            <select id="mail_cc" name="mail_cc[]" class="form-control" style="width: 250px" multiple="multiple">
                <option value="1">Abhayan</option>
                <option value="2">Srinithy</option>
                <option value="3">Parthipan</option>
                <option value="4">Sanchayan</option>
            </select>
        </td>
    </tr>
</table>

<br>

<table width="100%">
    <tr>
        <td width="20%"><label>Note</label></td>
        <td><textarea class="form-control" name="note"></textarea></td>
    </tr>

    <tr>
        <td><br></td><td></td>
    </tr>

    <tr>
        <td width="20%"><label>Attachment (Quotations)</label></td>
        <td>
        {!! Form::file('attachment','',array('id'=>'attachment','class'=>'form-control')) !!}
        </td>
    </tr>
</table>

<br>
<br>

{!! Form ::close() !!}

<div align="right">
    {{--{!! Form::submit('Verify',['class' => 'btn btn-primary']) !!}--}}
    <script type="text/javascript">
        $(document).ready( function()
        {
    		$("#alert_button").click( function()
    		{
     		    jAlert('Do you want to verify and submit', 'Alert Dialog');
     		});
     	});

   	</script>

    <input type="button"  name="Verify" value="Verify" class="btn btn-success" style="width: 80px; height: 36px" onclick="findSum()">
    {!! Form::submit('Submit',['class' => 'btn btn-primary','onclick'=>'javascript:return verify()']) !!}
</div>
</div>

<script>
  $(function () {
    $('#myTab a:first').tab('show')
  })
</script>

@endsection
@stop
