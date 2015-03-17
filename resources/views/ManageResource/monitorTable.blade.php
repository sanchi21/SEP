<table class="table table-hover" id="hardwareTable">
        <tr id="headRow">
            <th>Inventory&nbsp;Code</th>
            <th width>Description</th>
            <th>Serial&nbsp;No</th>
            <th>IP&nbsp;Address&nbsp;</th>
            <th>Make&nbsp;</th>
            <th>Model</th>
            <th>Purchase&nbsp;Date</th>
            <th>Warranty&nbsp;Expiration</th>
            <th>Insurance</th>
            <th>Value</th>
        </tr>
        <tbody id="tableBody">
        <tr id="firstRow">
            <td>
                <input type="text" id="inventory_code_t" name="inventory_code_t[]" class="rounded" value="{{$key}}" readonly>
                {{--{!!Form::text('inventory_code_t','$id',['class'=>'rounded','readonly'])!!}--}}
            </td>

            <td>
            {!!Form::textarea('description_t[]','',['class'=>'rounded','size'=>'50x1'])!!}
            </td>

            <td>
            {!!Form::text('serial_no_t[]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('ip_address_t[]','',['class'=>'rounded'])!!}
            </td>

            <td>
            <select id="make_t" name="make_t[]" class="rounded">
                	        @foreach($types as $type)
                	       	    <option value='{{$type->category}}'>{{ $type->category }}</option>
                	        @endforeach
            </select>
            </td>

            <td>
            {!!Form::text('model_t[]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::input('date','purchase_date_t[]',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::input('date','warranty_exp_t[]',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::text('insurance_t[]','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('value_t[]','',['class'=>'rounded'])!!}
            </td>
        </tr>

        </tbody>
    </table>