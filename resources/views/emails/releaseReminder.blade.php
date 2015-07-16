
<br>
Hello {{$user}},
<br>
<br>
The below listed resource(s) for Project Code : {{$prCode}} expires on {{$dt}}
<br>
<br>
@foreach($items as $item)
Resource : {{$item->item}} [{{$item->inventory_code}}]
<br>
@endforeach
<br>
<br>
-----------------------------------------------------------------------------------------------------<br>
Please login to the system to renew the above listed resources.<br>
-----------------------------------------------------------------------------------------------------