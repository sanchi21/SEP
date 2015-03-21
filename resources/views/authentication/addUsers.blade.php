<?php
/**
 * User: abhayan.s
 * Date: 3/18/2015
 * Time: 8:07 AM
 */ ?>
 @extends('layout')
 
 @section('content')

 <form action="{{ URL::route('add-user-post') }}" method="post">

    <div class="field">
            Username: <input type="text" name="username">
            @if($errors->has('username'))
                {!! $errors->first('username') !!}
            @endif
    </div>
    <select name="sltPermissions">
        <option>Full access</option>
        <option>Partial Access</option>

    </select>
    {!! Form::token() !!}
    <input type="submit" value="Add User">


 </form>
    <table class="table table-striped">

       <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Delete</th>
            <th>Permissions</th>
            <th>Deactivate</th>
       </tr>
    @foreach($systemUsers as $systemUser)
        <tr>
            <td>{{ $systemUser->username }}</td>
            <td>{{ $systemUser->email }}</td>

            <form action="{{ URL::route('postDelete') }}" method="post">
            {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}
                    <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">
                    <td>{!! Form::submit('Delete') !!}</td>
                    {!! Form::token() !!}
            </form>


            <form action="{{ URL::route('permissionUpdate') }}" method="post">
                        {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}

                                 <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">
                                    {{--<input type="text" name="sltPermission">--}}
                                   <td><select name="sltPermission">
                                        <option>Full access</option>
                                        <option>Partial Access</option>
                                    </select>
                                    {!! Form::submit('Update') !!}</td>
                                {!! Form::token() !!}
            </form>

            <form action="{{ URL::route('accountDeactivate') }}" method="post">
                                    {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}
                        @if ($systemUser->active == 0)
                            {{$status="active"}}
                        @else
                        {{$status="deactive"}}
                        @endif
                                             <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">
                                                {{--<input type="text" name="sltPermission">--}}
                                               <td>
                                                {{--{!! Form::submit($status) !!}--}}
                                                <input type="submit" value="{{$status}}"></td>
                                            {!! Form::token() !!}
                        </form>

        </tr>
    @endforeach

    </table>
@endsection