@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}
</style>

<h2 style="color: #9A0000">Add To Inventory</h2>
<br>

@if($errors->any())
    <div class="alert alert-danger" id="error_msg">
    <ul style="list-style: none">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
@endif

<div class="span12" style="overflow:auto;">

    <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
        <tr id="headRow" style="background-color: #e7e7e7;">
            <th>Item</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit&nbsp;Price</th>
            <th>Total&nbsp;Price</th>
            <th>Warranty</th>
            <th>Item&nbsp;Type</th>
            <th>&nbsp;</th>
        </tr>

        <tbody id="tableBody">

        <?php $i=0; $j=1000?>
        @foreach($items as $item)
        <tr>
            <td>{{$item->item}}</td><input type="hidden" name="item_no" value="{{$item->item_no}}">
            <td>{{$item->description}}</td><input type="hidden" name="item_description" value="{{$item->description}}">
            <td>{{$item->quantity}}</td><input type="hidden" name="item_no" value="{{$item->quantity}}">
            <td>{{$item->price}}</td><input type="hidden" name="item_no" value="{{$item->price}}">
            <td>{{$item->price_tax}}</td><input type="hidden" name="item_no" value="{{$item->price_tax}}">
            <td>{{$item->warranty}}</td><input type="hidden" name="item_no" value="{{$item->warranty}}">
            <td>
                 <select id="{{$i}}" name='type' class="form-control input-sm" style="width:200px">
                    @foreach($types as $type)
                        <option value='{{$type->category}}'>{{ $type->category }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                   <?php $temp = '/'.urlencode(base64_encode($item->pRequest_no)).'/'.urlencode(base64_encode($item->id)); ?>
                   <input type="hidden" id="{{$j}}" value="{{$temp}}">
                 <input type="button" name="view" value="Add" class="btn btn-success" onclick="javascript:location.href = '/purchase-inventory/' + document.getElementById({{$i}}).value + document.getElementById({{$j}}).value;">
            </td>
            <?php $i++; $j++ ?>
        </tr>
        @endforeach

        </tbody>

    </table>

</div>

@endsection
@stop