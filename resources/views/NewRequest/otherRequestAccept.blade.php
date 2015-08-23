
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}
</style>

<h2 style="color: #9A0000">Other Requests Accept/Reject</h2>
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

<div class="alert alert-danger" id="error_msg" style="display: none">
         <label id="msg"></label>
         </div>

<div class="span12">
    <div class="well">
        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">Request Type</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <select id="request-type" name="request_type" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">

                    @foreach($requestTypes as $type)
                        <?php $name = str_replace('_','-',strtoupper($type->request_type)) ?>
                        <option value='/other-request-update/{{$type->request_type}}' @if($id==$type->request_type) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">PR Code</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <select name="PR_Code" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
                @foreach($prCodes as $pr)
                    <option value="/other-request-update/{{$id}}/{{$pr->pr_code}}" @if($pr->pr_code == $pr) selected @endif>{{$pr->pr_code}}</option>
                @endforeach
                </select>
            </div>

        </div>

        <br>

        <div class="row">

            {{--<div class="col-xs-4 col-md-2">--}}
                {{--<label style="font-size: 18px" name="category">From</label>--}}
            {{--</div>--}}

            {{--<div class="col-xs-4 col-md-4">--}}
                {{--{{$gRequest->from}}--}}
            {{--</div>--}}

            {{--<div class="col-xs-4 col-md-3">--}}
                {{--<label style="font-size: 18px" name="category">To</label>--}}
            {{--</div>--}}

            {{--<div class="col-xs-4 col-md-2">--}}
                {{--{{$gRequest->to}}--}}
            {{--</div>--}}
        </div>
    </div>
</div>

{!! Form ::open(['method' => 'POST', 'action' => ['OtherRequestController@update']]) !!}

<div class="span12" style="overflow:auto;">

    <input type="hidden" name="request_type" value="{{$id}}">
    <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
        <tr id="headRow" style="background-color: #e7e7e7;">
            @foreach($columns as $c)
                <?php $tm = str_replace(' ','&nbsp;', $c->column_name) ?>
                @if($c->table_column != 'status')
                <th>{{$tm}}</th>
                @endif
            @endforeach
            <th>Request&nbsp;Date</th>
            <th>From</th>
            <th>To</th>
            <th>Remarks</th>
            <th>Status</th>
        </tr>

        <tbody id="tableBody">

        @foreach($requests as $request)

        <tr>
            @foreach($columns as $col)
            @if($col->table_column != 'status')
            <td>
                <div class="hideextra">
                <?php $attribute = $col->table_column; ?>

                    {{$request->$attribute}}

                @if($attribute == 'request_id')
                        <input type="hidden" name="request_id[]" value="{{$request->request_id}}">
                        <input type="hidden" name="sub_id[]" value="{{$request->id}}">
                @endif
            </div>
            </td>
            @endif
            @endforeach

            <td>{{$request->date}}</td>
            <td>{{$request->from}}</td>
            <td>{{$request->to}}</td>
            <td><input type="text" name="remarks[]" class="form-control" value="{{$request->remarks}}"
            @if($request->status == 'Accepted' || $request->status == 'Rejected') readonly @endif></td>
            <td>


             @if($request->status == 'Accepted' || $request->status == 'Rejected')
                <select name="status[]" class="form-control" readonly>
                    <option value="{{$request->status}}">{{$request->status}}</option>
                </select>
             @else
                <select name="status[]" class="form-control">
                    <option value="Pending" @if($request->status == 'Pending') selected @endif>Pending</option>
                    <option value="Accepted" @if($request->status == 'Accepted') selected @endif>Accept</option>
                    <option value="Rejected" @if($request->status == 'Rejected') selected @endif>Reject</option>
                </select>
             @endif
            </td>
        </tr>

        @endforeach

        </tbody>
    </table>

</div>

<div class="panel-body" align="right">
{!! Form::submit('Update',['class' => 'btn btn-success','onclick'=>'javascript:return validation()']) !!}
{{--{!! Form ::token()!!}--}}
</div>
<br>

{!! Form ::close() !!}

@endsection
@stop