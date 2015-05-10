<?php
/**
 * User: abhayan.s
 * Date: 3/16/2015
 * Time: 10:47 AM
 */ ?>

@extends('layout-login')



@section(('content'))
<div class="content-main" style="opacity: 0.8;">
<center>
    <div class="panel panel-default" style="background-color: #fffff" >
      <div class="panel-body">

        <form action ="{{ URL::route('postLogin') }}" method="post">
        <table style="width: 100%">
        <tr>
            <td colspan="2">
                <img src="{{ asset('/includes/images/zone_logo.png') }}" style="width: 310px; height: 86px">
                <br><br>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            @if (Session::has('flash_message'))
                <div class="alert alert-danger" role="alert" id="divAlert" style="font-size: 14px">
                    {{Session::get('flash_message') }}
                </div>
            @elseif(Session::has('flash_message_success'))
                                   <div class="alert alert-success" role="alert" id="divAlert" style="font-size: 14px">
                                      <span class="glyphicon glyphicon-envelope"></span> {{Session::get('flash_message_success') }}
                           </div>

            @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <div class="input-group" style="width: 100%">
              <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user"></span> </span>
                 <input type="text" placeholder="username" id="email" class="form-control" name="email"{{ (Input::old('email')) ? ' value=' . e(Input::old('email')) . ' ' : '' }} style="width: 100%; background-color: #e7e7e7">
            </div>
                            @if (count($errors) > 0)

                                     <div style="color: #af3838; text-align: right; font-size: 14px">
                                     <i>
                                     @if($errors->has('email'))
                                        <span class ="glyphicon glyphicon-remove"></span>    {{ $errors->first('email') }}
                                        <script type="text/javascript">
                                            document.getElementById('email').style.border='solid';
                                            document.getElementById('email').style.borderColor='#af3838';
                                        </script>
                                     @endif
                                     </i>
                                     </div>
                             @endif
                 <br>
            </td>
        </tr>
        <tr>

            <td colspan="2">
            <div class="input-group" style="width: 100%">
              <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock"></span></span> </span>
                 <input type="password" id="password" placeholder="password" class="form-control"  name="password" style="width: 100%; background-color: #e7e7e7;">
            </div>

             {{--{!! Form::password('password') !!}--}}
                        <div style="color: #af3838; text-align: right; font-size: 14px"><i>
                         @if($errors->has('password'))
                             <span class ="glyphicon glyphicon-remove"></span> {{ $errors->first('password') }}
                             <script type="text/javascript">
                                 document.getElementById('password').style.border='solid';
                                 document.getElementById('password').style.borderColor='#af3838';
                             </script>
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
                <input type="submit" value="Sign In" class="btn btn-info" style="width: 100%">
                </td>
        </tr>
        </table>


             {!! Form::token() !!}

        </form>
      </div>
    </div>
    </center>
</div>

 @endsection