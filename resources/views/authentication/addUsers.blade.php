<?php
/**
 * User: abhayan.s
 * Date: 3/18/2015
 * Time: 8:07 AM
 */ ?>
 @extends('layout')
 
 @section('content')
<script type="text/javascript">
                $(document).ready(function() {
                    $('#activeUserNames').multiselect({
                    enableFiltering: true,
                    buttonWidth: '200px'
                    });
                });
</script>
<script type="text/javascript">
                $(document).ready(function() {
                    $('#sltPermissions').multiselect({

                    buttonWidth: '200px'
                    });
                });
</script>

<H3 style="background-color: #95a5a6">Connect User</H3>
 <form action="{{ URL::route('add-user-post') }}" method="post">
 <div style="box-shadow: 5px 5px 5px #888888; border-style: groove; border-color: #e7e7e7">
<br>

 <table style="width: 100%;">
 <tr>
    <td >
    Pick username
    </td>
     <td>
     <select id="activeUserNames" name="activeUserNames">
             @foreach($activeUsers as $activeUser)
             <option>
                {{ $activeUser->username }}
             </option>
             @endforeach
    </select>
    </td>
    <td>
    Set Permissions
    </td>
    <td>
        <select name="sltPermissions" id="sltPermissions">
            <option>Administrator Full</option>
            <option>Administrator Limit</option>
            <option>Project Manager</option>
        </select>
    </td>
    <td>
        {!! Form::token() !!}
        <input type="submit" value="Connect User" class="btn btn-info" >
        <br>
    </td>
 </tr>
 <tr>
 <td colspan="5">
 <br>
@if (Session::has('flash_message'))
                <div class="alert alert-danger" role="alert" id="divAlert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('flash_message') }}
                </div>
                @elseif(Session::has('flash_message_success'))
                <div class="alert alert-success" role="alert" id="divAlert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{Session::get('flash_message_success') }}
                                </div>
@endif</td>

 </tr>

 </table>
 </div>






 </form>

<H3 style="background-color: #95a5a6">Current Users</H3>
    <table class="table table-hover">

       <tr style="background-color: #e7e7e7">
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>

            <th>Permissions</th>
             <th>Delete</th>
            <th>Status</th>
       </tr>
    @foreach($systemUsers as $systemUser)
        <tr>
            <td>{{ $systemUser->id }}</td>
            <td>{{ $systemUser->username }}</td>
            <td>{{ $systemUser->email }}</td>




            <form action="{{ URL::route('permissionUpdate') }}" method="post">
                        {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}

                                 <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">
                                    {{--<input type="text" name="sltPermission">--}}
                                   <td><select name="sltPermission" class="form-group" style="height: 32px">
                                        <option>Administrator Full</option>
                                        <option>Administrator Limit</option>
                                        <option>Project Manager</option>
                                    </select>
                                   <button type="submit" class="btn btn-default" aria-label="Left Align">
                                      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
                                    </button></td>
                                {!! Form::token() !!}
            </form>

            <form action="{{ URL::route('postDelete') }}" method="post">
                        {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}
                                <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">

                                <td>
                                <button type="submit" class="btn btn-default" aria-label="Left Align">
                                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
                                </button>

                                {{--{!! Form::submit('Delete') !!}</td>--}}
                                {!! Form::token() !!}
                        </form>

            <form action="{{ URL::route('accountDeactivate') }}" method="post">
                                    {{--{!! Form::open(array('action' => array('Authentication_Controller@postDeActivate'))) !!}--}}
                        @if ($systemUser->active == 0)
                            {{--<p style="color: #ffffff">{{$status="active"}}</p>--}}
<?php $status = "deactive"?>
                             <td>
                             <div class="btn-group" role="group" aria-label="...">
                             <button type="button" class="btn btn-danger" aria-label="Left Align" style="height: 34px">
                                       <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                                 </button>

                             <input type="submit" value="Activate" class="btn btn-default"  style="width: 90px">
                             </div>
                             </td>
                        @else
                        {{--<p style="color: #ffffff">{!!$status="deactive"!!}</p>--}}
                        <?php $status = "deactive"?>
                        <td>
                        <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-success" aria-label="Left Align" style="height: 34px">
                                                               <span class="glyphicon glyphicon-ok-sign" aria-hidden="true" ></span>
                                                         </button>
                                                         <input type="submit" value="Deactiavte" class="btn btn-default" style="width: 90px"> </div></td>
                        @endif
                                             <input type="hidden" value="{{$systemUser->id}}" name="hiddenId">
                                                {{--<input type="text" name="sltPermission">--}}

                                                {{--{!! Form::submit($status) !!}--}}
                                                {{--<input type="submit" value="{{$status}}"></td>--}}
                                            {!! Form::token() !!}
                        </form>

        </tr>
    @endforeach

    </table>
@endsection