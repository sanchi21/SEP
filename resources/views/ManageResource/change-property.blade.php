
@extends('...master')

@section('content')

{!! Form ::open(array('url' => 'change-property')) !!}
<div>
<label>Attribute Name</label>
<input type="text" name="attribute"/>
<br>
<label>Attribute Type</label>
<input type="text" name="type"/>

</div>

<div>
<input type="submit" class="btn btn-success" width="100px" name="add" value="Submit">
</div>

{!! Form ::close() !!}

@endsection
@stop