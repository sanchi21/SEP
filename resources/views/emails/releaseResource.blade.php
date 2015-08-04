
<br>
Hello {{$user}},
<br>
<br>
The below listed resource(s) for Project Code : {{$prCode}} has been released on {{$dt}}
<br>
<br>
@foreach($items as $item)
Resource : {{$item->type}} [{{$item->inventory_code}}]
<br>
@endforeach
<br>
<br>
------------------------------------------------------------------------------------------<br>
This is an auto gernerated mail<br>
------------------------------------------------------------------------------------------<br>