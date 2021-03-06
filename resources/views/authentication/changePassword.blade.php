<?php
/**
 * User: abhayan s
 * Date: 3/17/2015
 * Time: 7:39 PM
 */
 ?>
{{--{!! Form::open(array('url' => 'account-change-password-post', 'method' => 'POST')) !!}--}}
@extends('layout-changePassword')



@section(('content'))

{{--{!! Form::submit('Submit!') !!}--}}

@if(Session::has('flash_message'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('flash_message')!!}
    </div>
    @elseif(Session::has('flash_message_success'))
     <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get('flash_message_success')!!}
    </div>
@endif
<form action="{{ URL::route('account-change-password-post') }}" method="post">

<table style="width: 100%">
    <tr>
    <td><h3>Change Password</h3></td>
    <td style="text-align: right"><input type="button" class="btn btn-default" value="Back to Home" onclick="window.location.href='{{ URL::route('home-admin-full') }}'" /></td>
    </tr>
</table>

<hr>
<table >
<tr>
    <td> Old password:</td>
    <td>
     <input type="password" name="old_password" class="form-control"><br>

    </td>
    <td>
     @if($errors->has('old_password'))
                       <p style="color: darkred; font-size: 14px"> <span class="glyphicon glyphicon-remove"></span> {!!$errors->first('old_password')!!}</p>
                    @endif
    </td>
</tr>
<tr>
<td>  New password: </td>
<td>
<input type="password" name="password" class="form-control"><br>

            </td>
            <td>
            @if($errors->has('password'))
                            <p style="color: darkred; font-size: 14px">  <span class="glyphicon glyphicon-remove"></span> {!!$errors->first('password')!!}</p>
                        @endif
            </td>
</tr>
<tr>
<td>New password again: </td>
<td><input type="password" name="password_again" class="form-control"><br>

             </td>
             <td>@if($errors->has('password_again'))
                                <p style="color: darkred; font-size: 14px">  <span class="glyphicon glyphicon-remove"></span> {!!$errors->first('password_again')!!}</p>
                              @endif</td>
</tr>
<tr>
<td></td>
<td>
<input type="submit" value="Change password" class="btn btn-info">
</td>
</tr>
</table>


    {!! Form::token() !!}
</form>
@endsection