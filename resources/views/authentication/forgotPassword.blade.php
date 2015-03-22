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

<br>
<table style="width: 50%">
    <tr>
        <td>Email</td>
        <td>
         <div class="input-group">
              <input type="text" name="email" placeholder="email address" class="form-control" {{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} >
              <span class="input-group-btn">
                <input type="submit" value="recover" class="btn btn-info"></button>
              </span>
        </div>
        </td>
        {{--<input type="text" name="email" class="form-control" {{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} ></td>--}}
        {{--<td><input type="submit" value="recover" class="btn btn-info"></td>--}}
    </tr>
    <tr>
        <td></td>
        <td style="color: darkred"> <br> @if($errors->has('email'))
                   <div class="alert alert-danger" role="alert" id="divAlert">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                       {!! $errors->first('email')!!}
                                   </div>

                @endif
</td>
    </tr>

</table>


{!! Form::token() !!}

</form>

@endsection