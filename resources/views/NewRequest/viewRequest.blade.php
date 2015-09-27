
@extends('...master')

@section('content')
<style>
.table>tbody>tr>td {
    padding: 2px;
    border-spacing: 0px;
}
</style>

<h2 style="color: #9A0000">View Other Requests - {{str_replace('_',' ',$requestType)}}</h2>
<br>


<div class="span12">
    <div class="well">
        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">PR Code : </label>
            </div>

            <div class="col-xs-4 col-md-4">
                <label style="font-size: 18px" name="category">{{$prCode}}</label>
            </div>

            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="category">Status</label>
            </div>

            <div class="col-xs-4 col-md-4">
                <select name="status" class="form-control" onchange="javascript:location.href = this.value;">
                    <option value="/other-request-view/{{$requestType}}/{{$prCode}}/All" @if($status == 'All') selected @endif>All</option>
                    <option value="/other-request-view/{{$requestType}}/{{$prCode}}/Pending" @if($status == 'Pending') selected @endif>Pending</option>
                    <option value="/other-request-view/{{$requestType}}/{{$prCode}}/Accepted" @if($status == 'Accepted') selected @endif>Accepted</option>
                    <option value="/other-request-view/{{$requestType}}/{{$prCode}}/Rejected" @if($status == 'Rejected') selected @endif>Reject</option>
                </select>
            </div>
        </div>
    </div>
</div>


<div class="span12" style="overflow:auto;">

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
                <th></th>
            </tr>

            <tbody id="tableBody">

                @foreach($requests as $request)

                {!! Form ::open(['method' => 'POST', 'action' => ['OtherRequestController@cancel']]) !!}

                <input type="hidden" name="request_id" value="{{$request->request_id}}">
                <input type="hidden" name="request_type" value="{{$requestType}}">

                <tr>
                    @foreach($columns as $col)
                    @if($col->table_column != 'status')
                    <td>
                        <div class="hideextra">
                        <?php $attribute = $col->table_column; ?>

                            {{$request->$attribute}}

                        </div>
                    </td>
                    @endif
                    @endforeach

                    <td>{{$request->date}}</td>
                    <td>{{$request->from}}</td>
                    <td>{{$request->to}}</td>
                    <td>{{$request->remarks}}</td>
                    <td><b>{{$request->status}}</b></td>
                    <td>@if($request->status == 'Pending')
                            {!! Form::submit('Cancel',['class' => 'btn btn-Danger']) !!}
                        @endif
                    </td>
                </tr>

                {!! Form ::close() !!}

                @endforeach

                </tbody>
            </table>

</div>


@endsection
@stop