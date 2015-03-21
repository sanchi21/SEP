<?php
/**
 * User: abhayan s
 * Date: 3/17/2015
 * Time: 7:39 PM
 */
 ?>
{{--{!! Form::open(array('url' => 'account-change-password-post', 'method' => 'POST')) !!}--}}


{{--{!! Form::submit('Submit!') !!}--}}
@if(Session::has('flash_message'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('flash_message')!!}
    </div>
@endif
<form action="{{ URL::route('account-change-password-post') }}" method="post">
    <div class="field">
        Old password: <input type="password" name="old_password">
        @if($errors->has('old_password'))
            {!!$errors->first('old_password')!!}
        @endif
    </div>
    <div class="field">
        New password: <input type="password" name="password">
        @if($errors->has('password'))
            {!!$errors->first('password')!!}
        @endif
    </div>
    <div class="field">
        New password again: <input type="password" name="password_again">
         @if($errors->has('password_again'))
            {!!$errors->first('password_again')!!}
         @endif
    </div>
    <input type="submit" value="Change password">
    {!! Form::token() !!}
</form>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>