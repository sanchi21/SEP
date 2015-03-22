<?php
/**
 * User: abhayan.s
 * Date: 3/16/2015
 * Time: 10:47 AM
 */ ?>

@extends('layout-login')



@section(('content'))
<div class="content-main">
<center>
    <div class="panel panel-default" >
      <div class="panel-body">

        <form action ="{{ URL::route('postLogin') }}" method="post">
        <table style="width: 100%">
        <tr>
            <td colspan="2">
                <img src="{{ asset('/includes/images/zone_logo.png') }}" style="width: 310px; height: 86px">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            @if (Session::has('flash_message'))
                <div class="alert alert-danger" role="alert" id="divAlert">
                    {{Session::get('flash_message') }}
                </div>
            @elseif(Session::has('flash_message_success'))
                                   <div class="alert alert-success" role="alert" id="divAlert">
                                       {{Session::get('flash_message_success') }}
                           </div>

            @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 <input type="text" placeholder="email" class="form-control" name="email"{{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} style="width: 100%">
                            @if (count($errors) > 0)

                                     <div style="color: #af3838">
                                     <i>
                                     @if($errors->has('email'))
                                        {{ $errors->first('email') }}
                                     @endif
                                     </i>
                                     </div>
                             @endif
                 <br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 <input type="password" placeholder="password" class="form-control"  name="password" style="width: 100%">
             {{--{!! Form::password('password') !!}--}}
                        <div style="color: #af3838"><i>
                         @if($errors->has('password'))
                            {{ $errors->first('password') }}
                          @endif
                          </i>
                      </div>
                          <br>
            </td>
        </tr>
        <tr>
            <td>

                    <input type="checkbox" name="remember" id="remember"> Remember me

            </td>
            <td style="text-align: right">
            <a href=" {{ URL::route('forgotPassword') }}">Forgot password</a>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <br>
                <input type="submit" value="signIn" class="btn btn-info" style="width: 100%">
                </td>
        </tr>
        </table>



<br><br>

<br><br>

             {!! Form::token() !!}

        </form>
      </div>
    </div>
    </center>
</div>

 @endsection