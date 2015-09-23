@extends('...master')

@section('content')
<style>
    .table>tbody>tr>td {
        padding: 3px;
    }

    .dropdown-menu {
    max-height: 370px;
    overflow-y: auto;
    overflow-x: hidden;
    }

    .multiselect-container>li>a>label {
        padding: 0px 20px 0px 10px;
        }

    .btn .caret {
    margin-left:120px;
    }

    /*.btn*/
    /*{*/
    /*text-align: left;*/
    /*}*/
</style>

<script type="text/javascript">
                $(document).ready(function() {
                    $('#existing_attribute').multiselect({
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



<h2 style="color: #9A0000">Add, Edit Category & Attributes</h2>
<br>

{!! Form ::open(array('url' => 'change-property')) !!}

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

<div class="panel-body">
<div class="well">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <label style="font-size: 18px" name="category">Category</label>
        </div>


        <div class="col-xs-4 col-md-4">

            <select id="category" name="category" class="form-control" style="width: 250px" onchange="javascript:location.href = this.value;">
    	        @foreach($types as $type)
    	       	    <option value='/change-property/{{$type->category}}' @if($type->category == $id) selected @endif>{{ $type->category }}</option>
    	        @endforeach
    	        <option value='/change-property/New' @if('New' == $id) selected @endif>+ New</option>
            </select>

        </div>

        <div class="col-xs-4 col-md-3">
            <label style="font-size: 18px" name="inventory_code">Inventory&nbsp;Code&nbsp;Pattern</label>
        </div>

        <div class="col-xs-4 col-md-2">
            <table>
            <tr>
                <td>
                @if($id!='New')
                {!! Form :: text('inv',null,['id'=>'inv1','style'=>'width:180px','class'=>'form-control input-sm','disabled'=>'true'])!!}
                {{--<input type="text" name='inv' id="inv1" class="form-control input-sm" style="width:180px" @if($id!='New') disabled @endif></td>--}}
                @else
                {!! Form :: text('inv',null,['id'=>'inv1','style'=>'width:180px','class'=>'form-control input-sm'])!!}
                @endif
                <td>&nbsp;/&nbsp;0001</td>
            </tr>
            </table>
        </div>

    </div>

    <br>

        <div class="row">
            <div class="col-xs-4 col-md-2">
                <label style="font-size: 18px" name="new_category_l">New Category</label>
            </div>


            <div class="col-xs-4 col-md-4">
                <td>
                    @if($id!='New')
                    {!! Form :: text('new_category',null,['id'=>'new_category','style'=>'width:250px','class'=>'form-control input-sm','disabled'=>'true'])!!}
                    {{--<input type="text" id="new_category" name='new_category' class="form-control input-sm" style="width:250px" @if($id!='New') disabled @endif>--}}
                    @else
                    {!! Form :: text('new_category',null,['id'=>'new_category','style'=>'width:250px','class'=>'form-control input-sm'])!!}
                @endif
                </td>
            </div>

            <div class="col-xs-4 col-md-3">
                <label style="font-size: 18px" name="inventory_code">Attributes&nbsp;From&nbsp;Existing</label>
            </div>

            <div class="col-xs-4 col-md-2">
                <select id="existing_attribute" name="existing_attribute[]" class="form-control" style="width: 250px" multiple="multiple">
                    @foreach($columns as $col)
                        @if($col->table_column != 'inventory_code')
                   	    <option value='{{$col->table_column}}'>{{ $col->column_name }}</option>
                   	    @endif
                    @endforeach
                </select>
            </div>

        </div>
</div>
<br>


<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%">
        <tr id="headRow" style="background-color: #e7e7e7">
            <th>Attribute&nbsp;Name</th>
            <th>Attribute&nbsp;Type</th>
            <th>Min&nbsp;</th>
            <th>Max</th>
            <th>Drop&nbsp;Down</th>
            <th>Validate&nbsp;For</th>
        </tr>

        <tbody id="tableBody">
        <tr id="firstRow">
            <td>
                <input type="text" name="attribute_name"  class="form-control input-sm" style="width:184px">
            </td>

            <td>
                <select id="attribute_type" name="attribute_type" class="form-control input-sm" style="width: 184px" onchange="change()">
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
                <input type="text" name="attribute_min" id="min_attr"  class="form-control input-sm" style="width:184px">
            </td>

            <td>
                <input type="text" name="attribute_max" id="max_attr" class="form-control input-sm" style="width:184px">
            </td>

            <td>
                <select id="attribute_drop" name="attribute_drop" class="form-control input-sm" style="width: 184px">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </td>

            <td>
                <select id="attribute_validation" name="attribute_validation" class="form-control input-sm" style="width: 184px">
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

    {{--<input type="button" name="add" class="btn btn-primary form-control" value="+" style="width: 40px; font-size: 18px" onclick="addButton()">--}}
    {{--<input type="button" name="remove" class="btn btn-primary form-control" value="-" style="width: 40px; font-size: 18px" onclick="removeButton()">--}}
    {{--<br>--}}
    {{--<br>--}}
</div>
<br>

<div class="panel-body" align="right">
@if($id=="New")
<a href="#" class="btn btn-danger" style="width: 85px" data-toggle="modal" data-target="#basicModal" disabled>Delete</a>
@else
<a href="#" class="btn btn-danger" style="width: 85px" data-toggle="modal" data-target="#basicModal">Delete</a>
@endif
{!! Form::submit('Save',['class' => 'btn btn-primary form-control','onclick'=>'javascript:return validation3()']) !!}
</div>

<br>
<div style="height: 300px"></div>
{!! Form ::close() !!}


{!! Form ::open(array('url' => 'delete-property')) !!}
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color: #9A0000">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
            <h4 class="modal-title" id="myModalLabel">Delete Category / Attributes</h4>
            </div>
            <div class="modal-body"  style="height: 125px">
                <table width="100%" cellspacing="20px" cellpadding="50px">
                    <tr>
                        <td width="50%">Category</td>
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
            <div class="btn btn-warning">Warning : Deleting Attributes or Category might result in loss of data permanently!</div>
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

@endsection
@stop

<script type="text/javascript">
    function confirmDelete()
    {
        var check = confirm("Do you want to permanently delete this?");
        return check;
    }
</script>

<script>
    function change()
    {
        var type = document.getElementById("attribute_type").value;
        resetList();
        if(type == "bigInteger" || type == "smallInteger" || type == "tinyInteger" || type == "integer" || type == "mediumInteger" || type == "double" || type == "float")
        {
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
        }
        else if(type == 'string')
        {
            document.getElementById('2').disabled = true;
            document.getElementById('4').disabled = true;
            document.getElementById('6').disabled = true;
            document.getElementById('9').disabled = true;
        }
        else if(type == 'date' || type == 'dateTime')
        {
            document.getElementById('1').disabled = true;
            document.getElementById('3').disabled = true;
            document.getElementById('4').disabled = true;
            document.getElementById('5').disabled = true;
            document.getElementById('6').disabled = true;
            document.getElementById('7').disabled = true;
            document.getElementById('8').disabled = true;
            document.getElementById('9').disabled = true;
            document.getElementById('10').disabled = true;
            document.getElementById('11').disabled = true;
            document.getElementById('12').disabled = true;
            document.getElementById('13').disabled = true;
            document.getElementById('14').disabled = true;
            document.getElementById('15').disabled = true;
        }

        if(type == "bigInteger" || type == "smallInteger" || type == "tinyInteger" || type == "integer" || type == "mediumInteger")
        {
            document.getElementById('min_attr').disabled = false;
            document.getElementById('max_attr').disabled = false;
        }
    }

    function resetList()
    {
        document.getElementById('1').disabled = false;
        document.getElementById('2').disabled = false;
        document.getElementById('3').disabled = false;
        document.getElementById('4').disabled = false;
        document.getElementById('5').disabled = false;
        document.getElementById('6').disabled = false;
        document.getElementById('7').disabled = false;
        document.getElementById('8').disabled = false;
        document.getElementById('9').disabled = false;
        document.getElementById('10').disabled = false;
        document.getElementById('11').disabled = false;
        document.getElementById('12').disabled = false;
        document.getElementById('13').disabled = false;
        document.getElementById('14').disabled = false;
        document.getElementById('15').disabled = false;
        document.getElementById('min_attr').disabled = true;
        document.getElementById('max_attr').disabled = true;
    }
</script>