

<br>
<br>
Request details with reference to the Request ID : <b>{{$requestNo}}</b>
<br><br>
<br>
Request Type : {{$type}}
<br><br>
<br>
@foreach($requestData as $request)
Status : {{$request->status}}  <pre>   </pre> Remarks : {{$request->remarks}}
<br>
@endforeach
<br>
<br>
-----------------------------------------------------------------------------------------------------<br>