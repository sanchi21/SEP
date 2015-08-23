

@extends('...master')

@section('content')

<br>
<br>
<br>


<div class = "form-group">

<label for =""> Resource Type</label>
{!!Form ::open(array('url'=>'search'))!!}

<select id="category" name="category_t" class="form-control" onchange="">
    	        @foreach($types as $type)
    	       	    <option value='/resource/{{$type->category}}'>{{ $type->category }}</option>
    	        @endforeach
            </select>

{!!Form::close()!!}

</div>


{{--{!!Form ::open(array('url'=>'search'))!!}--}}


    {{--{!!Form::text('keyword', null,['class'=>'form-control','placeholder'=>'Search Softwares'])!!}--}}
    {{--{!!Form::submit('Search')!!}--}}

    {{--{!!Form:close()!!}--}}



{{--<br>--}}
{{--<h2>Search Resources</h2>--}}



{{--{!! Form ::open(array('url' => 'search')) !!}--}}

    {{--{!! Form::select('resourseType', ['Hardware', 'Software', 'Account']) !!}--}}

    {{--<br>--}}
    {{--<br>--}}

    {{--{!!Form::text('keyword', null,['class'=>'form-control','placeholder'=>'Search Softwares'])!!}--}}

    {{--<br>--}}
    {{--<br>--}}

    {{--{!!Form::submit('Search')!!}--}}


{{--{!! Form ::close() !!}--}}
@stop