<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 19/7/2015
 * Time: 7:18 AM
 */
 ?>
 @extends('master')
 @section('content')

  <h2 style="color: #9A0000">Accounts And Folder Allocation</h2>

  <div class="panel-body">
        <table class="table table-hover" width="100%">
            <tr style="background-color: #e7e7e7;">
                <th width="80%">Project&nbsp;Code</th>
                <th width="10%">Requests</th>
                <th width="10%">View & Edit</th>
             </tr>

        <tbody>

        <form action="{{ URL::route('ViewFolderRequests') }}" method="post">
            <tr style="padding: 2px">

                <td>
                    <select class="form-control" name="project_ids">
                        <option>-- Select Project Code --</option>
                        @foreach($ids as $id)
                            <option>
                                    {{$id->project_id}}
                            </option>
                      @endforeach
                    </select>
                </td>

                <input type="hidden" value="{{$id->request_id}}" name="hid1">
                <input type="hidden" value="{{$id->project_id}}" name="hid2">
                <?php $value=$id->request_id; $value2=$id->sub_id ?>

                {!! Form::token() !!}
                <td> {!! Form::submit('View',['class'=>'btn btn-primary form-control','name'=>'ViewRequests']) !!}</td>
                <td><button type="submit" class="btn btn-primary" style="height: 32px;" name="allocation" id="allocation"><span class="glyphicon glyphicon-edit"></span> </button></td>


        </form>

        </tbody>
        </table>

        <input type="hidden" value="{{$value}}" name="value">
        <input type="hidden" value="{{$value2}}" name="value2">
  </div>

  @if( (Session::has('flash_ViewRequests') || Session::has('flash_message_url_success') || Session::has('flash_message_url_error')) && ($ftp_count != 0 || $folder_count != 0 ))

        <div class="panel panel-default" style="width: 100%">

             <div class="panel-heading" style="color: #9A0000">
                    <h5><b>Requests&nbsp;For&nbsp;Project&nbsp;-&nbsp;{{$project_id}}</b></h5>
             </div>

             <div class="panel-body">

                    <div >

                          @if(Session::has('flash_message_url_error'))
                          @if( ! (Session::has('flash_message_url_success')) )
                              <div class="alert alert-danger">
                                   {{Session::get('flash_message_url_error')}}
                              </div>
                          @endif
                          @endif

                          <script>
                              $('div.alert').delay(4000).slideUp(300);
                          </script>

                    </div>

                    <div>
                           @if( (Session::has('flash_message_url_success')) )

                               <div class="alert alert-success">
                                    {{Session::get('flash_message_url_success')}}
                               </div>

                           @endif

                           <script>
                               $('div.alert').delay(4000).slideUp(300);
                           </script>

                    </div>

                    <div id="tab-count">

                        <ul class="nav nav-tabs">

                             <li  class="active" ><a href="#ftp" data-toggle="tab">FTP</a></li>
                             <li ><a href="#sharedFolder" data-toggle="tab">Shared&nbsp;Folder</a></li>

                        </ul>

                        <div class="tab-content">

                            <div  class="tab-pane active" id="ftp">

                                @if(Session::has('flash_ViewRequests') || Session::has('flash_message_url_success') || Session::has('flash_message_url_error'))
                                    @if($ftp_count == 0)

                                        </br></br>
                                        <h5 style="color: #9A0000">No FTP Account Requests</h5>
                                    @endif

                                    @if($ftp_count != 0)

                                         <table id="Table3"  class="table table-hover" style="width:100%;font-size: 14px">

                                            <tr style="background-color: #f5f5f5;">

                                                <th width="15%">Sub&nbsp;ID</th>
                                                <th width="15%">Type</th>
                                                <th width="15%">Username</th>
                                                <th width="15%">Password</th>
                                                <th width="15%">URL</th>
                                                <th width="5%"></th>
                                                <th width="5%"></th>

                                            </tr>
                                            <tbody>

                                            <?php $count=0?>
                                            @foreach($ftp_account as $ftp)

                                            <tr>
                                                <input type="hidden" value="{{$ftp->request_id}}" name="hid_requestid">
                                                <input type="hidden" value="{{$ftp->sub_id}}" name="hid_subid">

                                                <td ><label>{{$ftp->sub_id}}</label></td>
                                                <td>{{$ftp->type}}</td>

                                                {{--@if( (Session::has('flash_Assign')  && $ftp->sub_id==$sub_id) || Session::has('flash_message_url_error'  && $ftp->sub_id==$sub_id) )--}}
                                                <form action="{{ URL::route('AssignDataToDb') }}" method="post">

                                                <td><input type="text" class="form-control" name="username" id="username" placeholder="Username"  style="height: 30px " tabindex="1" value="{{$username}}"  /></td>
                                                <td><input type="text" class="form-control" name="psw" id="psw"  placeholder="Password" style="height: 30px "   tabindex="1"   /></td>
                                                <td><input type="text" class="form-control" name="link" id="link" placeholder="Path"  style="height: 30px "   tabindex="1"  /></td>

                                                <input type="hidden" value="{{$ftp->sub_id}}" name="hid_s">
                                                <input type="hidden" value="{{$ftp->request_id}}" name="hid_r">

                                                <td>
                                                    {!! Form::submit('&#10004;',['class'=>'btn btn-success form-control','name'=>'AssignToDb','style'=>'width:60px']) !!}
                                                </td>

                                                {!! Form::token() !!}
                                                </form>


                                                <form action="{{ URL::route('CancelAccount') }}" method="post">

                                                    <input type="hidden" value="{{$ftp->sub_id}}" name="cancel_subid">
                                                    <input type="hidden" value="{{$ftp->request_id}}" name="cancel_requestid">

                                                <td>
                                                    {!! Form::submit('&Chi;',['class'=>'btn btn-danger form-control','name'=>'Cancel{{$ftp->sub_id}}','style'=>'width:60px','onClick' => 'popup()']) !!}

                                                    <input type="hidden" id ="valueCancel" name="valueCancel">
                                                </td>

                                                {!! Form::token() !!}

                                                </form>



                                            </tr>

                                            <?php $count++ ?>
                                            @endforeach

                                            </tbody>
                                         </table>
                                    @endif
                                @endif

                            </div>


                            <div  class="tab-pane" id="sharedFolder">

                                <table id="TableFolder"  class="table table-hover" style="width:100%;font-size: 14px">

                                @if($folder_count == 0)

                                    </br></br>  <h5 style="color: #9A0000">No Folder Requests</h5>

                                @endif

                                @if($folder_count != 0)

                                     <tr style="background-color: #f5f5f5;">

                                        <th width="15%">Sub&nbsp;ID</th>
                                        <th width="15%">Username</th>
                                        <th width="15%">permission</th>
                                        <th width="15%">Folder&nbsp;Path</th>
                                        <th width="5%"></th>

                                    </tr>

                                    <?php $subIdValue="" ?>

                                    @foreach($sharedFolderRequests as $request)

                                    <tr>

                                        <td>{{$request->sub_id}}</td>
                                        <td>{{$request->user_name}}</td>
                                        <td>{{$request->permision}}</td>

                                        <form action="{{ URL::route('AssignSharedFolder') }}" method="post">

                                         <td>@if($subIdValue != $request->sub_id)<input type="text" class="form-control" name="path" id="path" placeholder="path"  style="height: 30px " tabindex="1"/>@endif</td>

                                        @if($subIdValue != $request->sub_id)

                                            <td>{!! Form::submit('&#10004;',['class'=>'btn btn-success form-control','name'=>'AssignToDb','style'=>'width:60px']) !!}</td>

                                        @endif

                                        <input type="hidden" id ="folderRequestId" name="folderRequestId" value={{$request->request_id}}>
                                        <input type="hidden" id ="folderSubId" name="folderSubId" value={{$request->sub_id}}>

                                        {!! Form::token() !!}

                                        </form>

                                        <form action="{{ URL::route('CancelSharedFolder') }}" method="post">

                                        @if($subIdValue != $request->sub_id)

                                            <td>{!! Form::submit('&Chi;',['class'=>'btn btn-danger form-control','name'=>'AssignToDb','style'=>'width:60px','onClick' => 'popup2()']) !!}</td>

                                        @endif

                                        <input type="hidden" id ="folderRequestId" name="cancelFolderRequestId" value={{$request->request_id}}>
                                        <input type="hidden" id ="folderSubId" name="cancelFolderSubId" value={{$request->sub_id}}>
                                        <input type="hidden" id ="folderCancelVale" name="folderCancelVale">

                                        </form>

                                    </tr>

                                    <?php $subIdValue= $request->sub_id ?>
                                    @endforeach

                                @endif
                                </table>

                            </div>

                        </div>
                    </div>
             </div>
        </div>

  @endif



  <script>

  function popup(){
     var r = confirm("Are sure that you want to cancel this ftp account request?");
            if (r == true) {
                document.getElementById("valueCancel").value=true;
            } else {
               document.getElementById("valueCancel").value=false;
            }
   }

  function popup2(){
     var r = confirm("Are sure that you want to cancel this ftp account request?");
            if (r == true) {
                 document.getElementById("folderCancelVale").value=true;
            } else {
                  document.getElementById("folderCancelVale").value=false;
            }
      }

  </script>

 @endsection