<?php
/**
 * User: abhayan s
 * Date: 3/20/2015
 * Time: 1:16 PM
 */ ?>
@extends('layout-forgotPassword')



@section(('content'))

<table style="width: 100%">
    <tr>
    <td><h3>Having trouble signing in?</h3></td>
    <td style="text-align: right"><input type="button" class="btn btn-default" value="Back to Login" onclick="window.location.href='{{ URL::route('account-login') }}'" /></td>
    </tr>
</table>

<hr>
<p style="font-size: 14px; ">To reset your password, enter the email address you use to sign in to Zone 24x7 account.

</p>

<form action ="{{ URL::route('forgotPassword-post') }}" method="post">

<br>
<table style="width: 100%">
    <tr>

        <td>
         <div class="input-group" style="width: 100%">
              <input type="text" name="email" id="email" placeholder="email address"class="form-control" {{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} >
              <span class="input-group-btn">
                <input type="submit" value="recover" class="btn btn-info"></button>
              </span>
        </div>
        </td>
        {{--<input type="text" name="email" class="form-control" {{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} ></td>--}}
        {{--<td><input type="submit" value="recover" class="btn btn-info"></td>--}}
    </tr>

    <tr>

        <td style="color: darkred"> <br> @if($errors->has('email'))
                   <div class="alert alert-danger" role="alert" id="divAlert" style="font-size: 14px">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                       <span class="glyphicon glyphicon-remove"></span> {!! $errors->first('email')!!}
                   </div>
                    <script type="text/javascript">
                        document.getElementById('email').style.border='solid';
                        document.getElementById('email').style.borderColor='#af3838';
                    </script>

                @endif
        </td>
    </tr>
    <tr>
    <td></td>
    </tr>

</table>


{!! Form::token() !!}

</form>

@endsection