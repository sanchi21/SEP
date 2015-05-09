

<html>
<body>

<div>
@foreach($columns as $c)
<label>{{$c->column_name}}</label>
<br>
@endforeach

<br>
<br>

@foreach($types as $t)
<label>{{$t->category}}</label>
<br>
@endforeach

<br>
<br>

@foreach($arr as $a)
    @foreach($a as $ab)
        <label>{{$ab->value}}</label>
        <br>
    @endforeach
@endforeach

</div>
</body>
</html>


