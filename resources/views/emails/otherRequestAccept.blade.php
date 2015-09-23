

<br>
<br>
Request details with reference to the Request ID : <b>{{$requestNo}}</b>
<br><br>
<br>
Request Type : {{$type}}
<br><br>
<br>
    <table class="table table-hover" cellpadding="0" cellspacing="0" width="60%" style="font-size: 15px;">
        <tr id="headRow" style="background-color: #e7e7e7;">
            <th width="40%">Remarks</th>
            <th>Status</th>
        </tr>

        @foreach($requestData as $request)
            <tr>
                <td>
                    {{$request->remarks}}
                </td>
                <td>
                    {{$request->status}}
                </td>
            </tr>
        @endforeach
    </table>


<br>
<br>
-----------------------------------------------------------------------------------------------------<br>