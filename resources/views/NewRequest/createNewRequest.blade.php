@extends('...master')


@section('content')

<style>

    .table>tbody>tr>td {
        padding: 3px;
    }

    .dropdown-menu {
    max-height: 310px;
    overflow-y: auto;
    overflow-x: hidden;
    }

    .multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:120px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('#mandatory_attribute').multiselect({
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#modal_attribute').multiselect({
        enableFiltering: true,
        buttonWidth: '250px'
        });
    });
</script>



<h2 style="color: #9A0000">Create New Request Type</h2>
<br>

{!! Form ::open(['method' => 'POST', 'action' => ['RequestTableController@store']]) !!}
@if($errors->any())
 <div class="alert alert-danger" id="error_msg">
    <ul style="list-style: none">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
 </div>
 @endif

<div class="alert alert-danger" id="error_msg1" style="display: none">
    <label id="msg"></label>
</div>

<div class="panel-body" style="min-height: 520px">
<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <label style="font-size: 18px" name="request">Request&nbsp;Type</label>
        </div>


        <div class="col-xs-4 col-md-4">

            <select id="category" name="request_type" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
    	        @foreach($requestTypes as $type)
    	            <?php $name = str_replace('_','-',strtoupper($type->request_type))?>
    	       	    <option value='/request-type/{{$name}}' @if($name == $id) selected @endif>{{ $name }}</option>
    	        @endforeach
    	        <option value='/request-type/New' @if('New' == $id) selected @endif>+ New</option>
            </select>

        </div>

        <div class="col-xs-4 col-md-3">
            <label style="font-size: 18px" name="request_id_pattern">Request&nbsp;Code&nbsp;Pattern</label>
        </div>

        <div class="col-xs-4 col-md-2">
            <table>
            <tr>
                <td>
                @if($id!='New')
                {!! Form :: text('request_code',null,['id'=>'request_code','style'=>'width:250px','class'=>'form-control','disabled'=>'true'])!!}
                {{--<input type="text" name='inv' id="inv1" class="form-control input-sm" style="width:180px" @if($id!='New') disabled @endif></td>--}}
                @else
                {!! Form :: text('request_code',null,['id'=>'request_code','style'=>'width:250px','class'=>'form-control'])!!}
                @endif
            </tr>
            </table>
        </div>

    </div>

    <br>

        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="request_title">Title</label>
            </div>


            <div class="col-xs-4 col-md-4">
                <td>
                    @if($id!='New')
                    {!! Form :: text('new_title',null,['id'=>'new_title','style'=>'width:250px','class'=>'form-control','disabled'=>'true'])!!}
                    {{--<input type="text" id="new_category" name='new_category' class="form-control input-sm" style="width:250px" @if($id!='New') disabled @endif>--}}
                    @else
                    {!! Form :: text('new_title',null,['id'=>'new_title','style'=>'width:250px','class'=>'form-control'])!!}
                @endif
                </td>
            </div>

            <div class="col-xs-4 col-md-3">
                <label style="font-size: 18px" name="inventory_code">Mandatory&nbsp;Attributes</label>
            </div>

            <div class="col-xs-4 col-md-2">
                <input type="text" name="mandatory_attributes" class="form-control" style="width: 250px" value="Date, PR Code, From & To Date" disabled>
            </div>

        </div>

    <br>

        <div class="row">
                <div class="col-xs-4 col-md-2">
                    <label style="font-size: 18px" name="requesting">Requesting&nbsp;Group</label>
                </div>


                <div class="col-xs-4 col-md-4">

                    <select name="request_group" class="form-control" style="width: 250px">
            	        @foreach($groups as $group)
            	       	    <option value='{{$group->id}}' @if($group->id == $rGroup) selected @endif>{{ $group->group_name }}</option>
            	        @endforeach
                    </select>

                </div>
                <div class="col-xs-4 col-md-3">
                    <label style="font-size: 18px" name="request">Approving&nbsp;Group</label>
                </div>


                <div class="col-xs-4 col-md-2">

                    <select name="approve_group" class="form-control" style="width: 250px">
                        @foreach($groups as $group)
                            <option value='{{$group->id}}' @if($group->id == $aGroup) selected @endif>{{ $group->group_name }}</option>
                        @endforeach
                    </select>

                </div>
        </div>
</div>
<br>

<table width="100%">
    <tr>
        <td width="18%"><label style="font-size: 18px">New Attributes</label></td>
        <td width="12%"><input type="checkbox" id="multiple_request" style="height: 25px; width: 25px" name="multiple_request" onclick="allowAdd()"></td>

        <td><input type="button" id="add_btn" name="add" class="btn btn-primary form-control" value="+" disabled style="width: 40px; height: 40px; font-size: 18px" onclick="addButton('columns_table')">
                <input type="button" name="remove" id="delete_btn" class="btn btn-primary form-control" disabled value="-" style="width: 40px; height: 40px; font-size: 18px" onclick="removeButton('columns_table')"></td>
        <td></td>
    </tr>
</table>

<br>
<div id="col_table" style="display: none">
<table class="table table-hover" id="columns_table" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">
            <th></th>
            <th>Attribute&nbsp;Name</th>
            <th>Attribute&nbsp;Type</th>
            <th>Min</th>
            <th>Max</th>
            <th>Drop&nbsp;Down</th>
            <th>Validate&nbsp;For</th>
        </tr>

        <tbody id="tableBody">
        <tr id="firstRow">

            <td>
                <input type='checkbox' class="form-control" style="height: 25px; width: 25px"/>
            </td>

            <td>
                <input type="text" name="attribute_name[]"  class="form-control input-sm" style="width:190px">
            </td>

            <td>
                <select id="attribute_type" name="attribute_type[]" class="form-control input-sm" style="width: 200px" onchange="change()">
                    <option value="bigInteger">BIG INTEGER</option>
                    <option value="date">DATE</option>
                    <option value="dateTime">DATETIME</option>
                    <option value="double">DOUBLE</option>
                    <option value="float">FLOAT</option>
                    <option value="integer">INTEGER</option>
                    <option value="mediumInteger">MEDIUM INTEGER</option>
                    <option value="smallInteger">SMALL INTEGER</option>
                    <option value="tinyInteger">TINY INTEGER</option>
                    <option value="string">STRING</option>
                </select>
            </td>

            <td>
                <input type="text" name="attribute_min[]" id="min_attr"  class="form-control input-sm" style="width:200px">
            </td>

            <td>
                <input type="text" name="attribute_max[]" id="max_attr" class="form-control input-sm" style="width:190px">
            </td>

            <td>
                <select id="attribute_drop" name="attribute_drop[]" class="form-control input-sm" style="width: 200px">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>

            <td>
                <select id="attribute_validation" name="attribute_validation[]" class="form-control input-sm" style="width: 200px">
                    {{--<option value="0">None</option>--}}
                    @foreach($validation as $valid)
                    <option value="{{$valid->id}}" id="{{$valid->id}}">{{$valid->valid_display}}</option>
                    @endforeach
                </select>

                <script>
                    document.getElementById('2').disabled = true;
                    document.getElementById('3').disabled = true;
                    document.getElementById('5').disabled = true;
                    document.getElementById('7').disabled = true;
                    document.getElementById('8').disabled = true;
                    document.getElementById('10').disabled = true;
                    document.getElementById('11').disabled = true;
                    document.getElementById('12').disabled = true;
                    document.getElementById('13').disabled = true;
                    document.getElementById('14').disabled = true;
                    document.getElementById('15').disabled = true;
                </script>
            </td>

        </tr>
        </tbody>
    </table>
</div>

<br>
<div align="right">
    {{--{!! Form::submit('Save',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validation3()']) !!}--}}
    <div class="panel-body" align="right">
    @if($id=="New")
    <a href="#" class="btn btn-danger" style="width: 85px" data-toggle="modal" data-target="#basicModal" disabled>Delete</a>
    @else
    <a href="#" class="btn btn-danger" style="width: 85px" data-toggle="modal" data-target="#basicModal">Delete</a>
    @endif
    {!! Form::submit('Save',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validateColumnsTable()']) !!}
</div>

</div>
{!! Form ::close() !!}


{!! Form ::open(array('url' => 'delete-request')) !!}

<div class="alert alert-danger" id="error_msg1" style="display: none">
    <label id="msg"></label>
</div>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color: #9A0000">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
            <h4 class="modal-title" id="myModalLabel">Delete Request Type / Attributes</h4>
            </div>
            <div class="modal-body"  style="height: 125px">
                <table width="100%" cellspacing="20px" cellpadding="50px">
                    <tr>
                        <td width="50%">Request Type</td>
                        <td width="50%">
                            {{$id}}<input type="hidden" name="modal_category" value="{{$id}}">
                        </td>
                    </tr>

                    <tr>
                        <td><br></td>
                        <td><br></td>
                    </tr>

                    <tr>
                        <td width="50%">Attributes</td>
                        <td width="50%">
                            <select id="modal_attribute" name="modal_attribute[]" class="form-control" style="width: 250px" multiple="multiple">
                            @foreach($delete_column as $col)
                   	                <option value='{{$col->cid}}'>{{ $col->column_name }}</option>
                            @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="container">
            <div class="btn btn-warning">Warning : Deleting Attributes or Request Type will result in loss of data permanently!</div>
            </div>
            <br>
            <div class="modal-footer">
                <input type="submit" class="btn btn-danger" value="Delete Category" name="delete_category" onclick="javascript:return confirmDelete()">
                <input type="submit" class="btn btn-danger" value="Delete Attributes" name="delete_attribute" onclick="javascript:return confirmDelete()">
        </div>
    </div>
  </div>
</div>
{!! Form ::close() !!}

<script>
    function allowAdd()
    {
        var add = document.getElementById('add_btn');
        var remove = document.getElementById('delete_btn');
        var table = document.getElementById('col_table');
        var multiple = document.getElementById('multiple_request').checked;

        if(multiple)
        {
            add.disabled = false;
            remove.disabled = false;
            table.style.display = 'block';
        }
        else
        {
            add.disabled = true;
            remove.disabled = true;
            table.style.display = 'none';
        }
    }
</script>

@endsection
@stop