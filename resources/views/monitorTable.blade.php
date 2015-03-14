
 <table class="table table-hover" id="hardwareTable">
        <tr id="headRow">
            <th>Inventory&nbsp;Code</th>
            <th>Screen&nbsp;Size</th>
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

        <tr>
            <td>
                {!!Form::text('inventory_code_t','CMB/MON/0001',['class'=>'rounded','readonly'])!!}
            </td>

            <td>
                {!!Form::text('sreen_size_t','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::textarea('description_t','',['class'=>'rounded','size'=>'50x1'])!!}
            </td>

            <td>
            {!!Form::text('serial_no_t','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('ip_address_t','',['class'=>'rounded'])!!}
            </td>

            <td>
            <select id="make" name="make" class="rounded">
                	        @foreach($types as $type)
                	       	    <option value='{{$type->category}}'>{{ $type->category }}</option>
                	        @endforeach
            </select>
            </td>

            <td>
            {!!Form::text('model_t','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::input('date','purchase_date_t',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::input('date','warranty_exp_t',null,['class'=>'form-control input-sm'])!!}
            </td>

            <td>
            {!!Form::text('insurance_t','',['class'=>'rounded'])!!}
            </td>

            <td>
            {!!Form::text('value_t','',['class'=>'rounded'])!!}
            </td>
        </tr>
    </table>