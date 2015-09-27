<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 23/9/2015
 * Time: 8:37 AM
 */

 ?>
 @extends('master')
 @section('content')

    <p></p></br>
    <div class="panel panel-default" style="width: 100%">
        <div class="panel-heading" style="color: #9A0000"><h4>VIEW & EDIT FTP ACCOUNTS</h4></div>
            <div class="panel-body">

                    <h4>Project Code: {{$project_id}}</h4>
                    </br>

                    <table id="Table1"  class="table table-hover-l" style="width: 97%">
                          <tbody>
                                <tr>
                                    <th  style="color: #9A0000">Edit</th>
                                    <th>Sub Id</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>URL</th>
                                    <th width="5%"></th>
                                    <th></th>
                                </tr>



                                @foreach($ftpAccountAllocations as $ftp)
                                 <form action="{{ URL::route('EditAccountChanges') }}" method="post">
                                <tr>

                                    <td><input id="{{$ftp->sub_id}}" name="remember[]" type="checkbox" onclick="validate( '{{$ftp->sub_id}}' )" /></td>
                                    <td>{{$ftp->sub_id}}</td>
                                    <td><input type="text" class="form-control" name="username" id="username{{$ftp->sub_id}}" placeholder="Username"  style="height: 30px " tabindex="1" value="{{$ftp->username}}" disabled /></td>
                                    <td><input type="password" class="form-control" name="psw" id="psw{{$ftp->sub_id}}"  placeholder="Password" style="height: 30px "   tabindex="1" value="{{$ftp->password}}"  disabled /></td>
                                    <td><input type="text" class="form-control" name="link" id="link" placeholder="Path"  style="height: 30px "   tabindex="1" value="{{$ftp->link}}" disabled /></td>

                                    <input type="hidden" value="{{$ftp->sub_id}}" name="hid_s">
                                    <input type="hidden" value="{{$ftp->request_id}}" name="hid_r">
                                    <input type="hidden" value="{{$project_id}}" name="hid_p">
                                     <input type="hidden" value="{{$ftp->link}}" name="link">


                                    <td> {!! Form::submit('✔ ',['class'=>'btn btn-success form-control','name'=>'save','style'=>'width:60px']) !!}</td>
                                    <td> {!! Form::submit('✖',['class'=>'btn btn-danger form-control','name'=>'cancel','style'=>'width:60px']) !!}</td>

                                </tr>
                                {!! Form::token() !!}

                                 </form>
                                @endforeach

                          </tbody>
                    </table>




            </div>
    </div>

<script type=text/javascript>
function validate(ID){
    var remember = document.getElementById(ID);
    var q="username"
    var p=ID;
    var b= q.concat(p);

    var password1="psw"
    var password2=password1.concat(p);

    if (remember.checked){

        document.getElementById(b).disabled= false;
        document.getElementById(password2).disabled= false;
    }
    else{

        document.getElementById(b).disabled= true;
        document.getElementById(password2).disabled= true;
    }
}
</script>


 @endsection