<?php
/**
 * User: abhayan s
 * Date: 3/20/2015
 * Time: 1:16 PM
 */ ?>
@extends('layout-forgotPassword')



@section(('content'))

<h3>Having trouble signing in?</h3>

<hr>
To reset your password, enter the email address you use to sign in to Zone 24x7 account.
<form action ="{{ URL::route('forgotPassword-post') }}" method="post">
<div class="field">
<table style="width: 50%">
    <tr>
        <td>Email</td>
        <td><input type="text" name="email" class="form-control" {{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} ></td>
        <td><input type="submit" value="recover" class="btn btn-info"></td>
    </tr>

</table>

    @if($errors->has('email'))
        {!! $errors->first('email')!!}
    @endif
</div>

{!! Form::token() !!}

</form>

@endsection