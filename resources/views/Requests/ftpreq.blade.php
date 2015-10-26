
@extends('master')

@section('content')

   {{--<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">--}}

   <script type="text/javascript">
                $(document).ready(function() {
                    $('#user').multiselect({
                    enableFiltering: true,
                    buttonWidth: '350px'
                    });
                });
   </script>

   <script>
                $(document).ready(function(){
                    $("button").click(function(){
                    $("#Table3").toggle();
                    $("#Table4").toggle();
                    });
                });
   </script>

   <style>
         .dropdown-menu
         {
             max-height: 280px;
             overflow-y: auto;
             overflow-x: hidden;
         }

         .btn
         {
         text-align: left;
         }

         .multiselect-container>li>a>label {
             padding: 0px 20px 0px 10px;
             }

         .btn .caret {
         margin-left:210px;
         }
   </style>

    {!! Form::open() !!}

    <h3 style="color: maroon">Request For Account And Folder</h3></br>

    <select class="form-control" name="project_id" style="width: 25%">
            @foreach($pros as $pro)
                <option>
                     {{$pro['PR_Code']}}
                </option>
            @endforeach
    </select>

    </br>

    <table class="table table-hover" >
        <tbody>
            <style>
                    input[type="checkbox"]{
                    width: 30px; /*Desired width*/
                    height: 30px; /*Desired height*/
                    }
            </style>

            <td width="5%">{!! Form::checkbox('ftp_account', 'yes',['class'=>'form-control','style'=>'width:30px','height:30px']) !!}</td>
            <td> <h4>Request for FTP Account</h4></td>
        </tbody>
    </table>

    </br>


    <div>
         <div class="row">
                <div class="col-xs-4 col-md-4">
                    <h4>&nbsp;&nbsp;Shared Folder Request</h4>
                </div>

                <div class="col-xs-2 col-md-2">
                    <h3><input type="button" value="+"  class="sbtn" style="width: 35px;height: 35px" onClick="add_Row_folder('Table_folder')" />&nbsp;
                    <input type="button" value="-" class="sbtn" style="width: 35px;height: 35px" onClick="delete_Row_folder('Table_folder')" /></h3>
                </div>

         </div>
    </div>

    <table class="table table-hover"  >

        <tr id="headRow" style="background-color: #e7e7e7;">
            <th width="4%"></th>
            <th width="30%">Users</th>
            <th width="20%">Permision</th>
        </tr>

    </table>

    <table  id="Table_folder" class="table table-hover" style="font-size: small;font-family: Arial " >
        <tbody>
            <tr>
                <style>
                        input[type="checkbox"]{
                        width: 30px; /*Desired width*/
                        height: 30px; /*Desired height*/
                         }
                </style>

                <td width="3%">
                    <input type='checkbox' class="form-control"/>
                </td>

                <td width="50%">
                    <select class="form-control"  name="user[]" style="width: 100%">
                            <option>Users</option>
                            @foreach($sys_users as $user)
                                <option>
                                    {{$user->username}}|{{$user->id}}
                                </option>
                            @endforeach
                    </select>
                </td>

                <td width="50%">
                    <select class="form-control" name="permissions[]" style="width: 100%">
                            <option>read</option>
                            <option>write</option>
                    </select>
                </td>

            </tr>
        </tbody>
    </table>

    <input type="hidden" id = "count_rows_folder" name="count_rows_folder">

    <div  style="width: 20%">{!! Form::submit('Request',['class'=>'btn btn-info','name'=>'folder','onClick'=>'getRow_folder()']) !!}</div>

    <div align="right">{!! Form::submit('View',['class'=>'btn btn-info','name'=>'view_all']) !!}</div>

    {{--Table view of both ftp accounts and shared folder--}}

    @if(Session::has('flash_view_accounts'))

    @if($project_id !=null)

    <h5 style="color: darkred"><b>Project&nbsp;ID&nbsp;-&nbsp;{{$project_id}}</b> </h5>

    <table id="Table_ftp_folder"   class="table table-hover" style="font-size: small;font-family: Arial "  >
        <tbody>

                <tr style="width: 20%;"><b>
                    <th> Request_ID </th>
                    <th> Sub_ID </th>
                    <th> Type </th>
                    <th> User Id</th>
                    <th> Username</th>
                    <th> Permission</th>
                    <th> Request Status</th></b>
                </tr>

                <!--Get all requests made by pr -->

                @foreach($getAllFtpRequests as $ftp_req)
                <tr>
                    <td>{{$ftp_req->request_id}}</td>
                    <td>{{$ftp_req->sub_id}}</td>
                    <td>{{$ftp_req->type}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color: darkred">{{$ftp_req->status}}</td>
                </tr>
                @endforeach

                <!--Get all requests made by pr -->

                @foreach($getAllFolderRequests as $folder_req)
                <tr>
                    <td>{{$folder_req->request_id}}</td>
                    <td>{{$folder_req->sub_id}}</td>
                    <td>{{$folder_req->type}}</td>
                    <td>{{$folder_req->user_id}}</td>
                    <td>{{$folder_req->user_name}}</td>
                    <td>{{$folder_req->permision}}</td>
                    <td></td>

                </tr>
                @endforeach

        </tbody>
    </table>

    @endif

    @endif

    {!! Form::close() !!}


 <script>

     function add_Row_folder(tableID) {
    	    var table = document.getElementById(tableID);
    	    var rowCount = table.rows.length;

    		var row = table.insertRow(rowCount);
    		var colCount = table.rows[0].cells.length;
    		for(var i=0; i<colCount; i++) {
    			var newcell = row.insertCell(i);
    			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
    		}
    	}

     function delete_Row_folder(tableID) {
    	    var table = document.getElementById(tableID);
      	var rowCount = table.rows.length;
    	    for(var i=0; i<rowCount; i++) {
    		   var row = table.rows[i];
    		   var chkbox =row.querySelector('input[type=checkbox]');
    		   if(null != chkbox && true == chkbox.checked) {
    			  if(rowCount <= 1) {               // limit the user from removing all the fields
    				 alert("Cannot Remove all the requests..");
    				 break;
    			  }
    			  table.deleteRow(i);
    			  rowCount--;
    			  i--;
    		   }
    	    }

     }

     function getRow_folder(Table_folder){
              var x = document.getElementById("Table_folder").rows.length;
              document.getElementById("count_rows_folder").value=x;

     }

 </script>

 @endsection



