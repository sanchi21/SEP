
Renewal Request
<br>
--------------------------
<br>
Project Code : {{$prCode[0]}}
<br>
Project Manager : {{$user}}
<br>
<br>

@for($i=0; $i< (int)$count ; $i++)

Renewal request for {{$item[$i]}}(Inventory Code :{{$inventory[$i]}}) upto {{$renewalDate[$i]}}
<br>

@endfor

<br>

-----------------------------------------------------------------------------------------------------