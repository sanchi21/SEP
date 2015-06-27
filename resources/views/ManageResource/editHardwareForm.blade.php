

@extends('master')

@section('content')

<h2 style="color: #9A0000">Edit Hardware Resource</h2>

{!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@update']]) !!}

         @if($errors->any())
            <div class="alert alert-danger" id="error_msg">
                <ul style="list-style: none">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
         @endif

<div class="panel-body">

<h3>{{$type}}</h3><input type="hidden" name="type" id="type" value="{{$type}}">
<br>
    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">

        <?php $x = 0;
         $y = 0;?>

        @foreach($columns as $col)

            <?php
               $attribute = $col->table_column;
            ?>

            @if($x == 0)
                <tr>
            @elseif($x % 2 == 0)
                </tr>
                <tr>
            @endif
                <td>
                    {{$col->column_name}}
                </td>
                <td>
                    @if($attribute == 'inventory_code')
                        {{$hardware->inventory_code}}<input type="hidden" name="inventory_code" value="{{$hardware->inventory_code}}">
                    @else
                        @if($col->dropDown == '1' && $y!=$count)
                            <select style="width: 250px" name='{{$col->table_column}}' class="form-control input-sm">
                                @foreach($dropValues[$y] as $v)
                                    <option value='{{$v->value}}' @if($hardware->$attribute == $v->value) selected @endif>{{ $v->value }}</option>
                                @endforeach
                            </select>
                            <?php $y++; ?>
                        @else
                            {!! Form :: text($col->table_column,$hardware->$attribute,['style'=>'width:250px','class'=>'form-control input-sm'])!!}
                        @endif
                    @endif
                </td>
                <?php $x++; ?>

        @endforeach

        @if($x % 2 != 0)
            <td></td>
            <td></td>
            </tr>
        @endif
        </tbody>
    </table>

</div>


                                        {{-- Buttons Panel  --}}

    <div class="container" align="right">
        @if($depreciation)
            <a href="#" class="btn btn-success" style="width: 120px" data-toggle="modal" data-target="#basicModal">Depreciate</a>&nbsp;&nbsp;
        @else
            <?php
                $inv = str_replace('/','-',($hardware->inventory_code));
                $temp = "/hardware-depreciate/".$inv  ?>
            <a href="{{$temp}}" class="btn btn-success" style="width: 120px">Depreciate</a>&nbsp;&nbsp;
        @endif

        <input type="button" onclick="printContent('content12')" class="btn btn-primary" value="Print">&nbsp;&nbsp;
        <input type="submit" name="delete" class="btn btn-danger" style="width: 85px" value="Delete">&nbsp;&nbsp;
        {{--<input type="submit" name="update" class="btn btn-primary" value="Update" onclick="javascript:return validation2()">--}}
        <input type="submit" name="update" class="btn btn-primary" value="Update">

{!! Form ::close() !!}
    </div>
<br/>




                {{-- Deprciation Modal --}}

    {!! Form ::open(array('url' => 'hardware-depreciate')) !!}
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="color: #9A0000">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                    <h4 class="modal-title" id="myModalLabel">Depreciation</h4>
                </div>

                <div class="modal-body">
                    <table width="100%" cellspacing="20px" cellpadding="50px">
                        <tr>
                            <td width="50%">Inventory Code</td>
                            <td width="50%">
                                {{$hardware->inventory_code}}<input type="hidden" name="inventory_code_dep" value="{{$hardware->inventory_code}}">
                            </td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td width="50%">Attributes</td>
                            <td width="50%">
                                <select id="modal_attribute" name="method" class="form-control" style="width: 250px" onclick="chk(this.value)">
                                    <option value="Straight Line">Straight Line Method</option>
                                    <option value="Declining">Declining Method</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td>Residual Value</td>
                            <td>
                                {!! Form :: text('residual',null,['style'=>'width:250px','class'=>'form-control input-sm','id'=>'residual'])!!}
                            </td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td>Life Time in Years</td>
                            <td>
                            {!! Form :: text('year',null,['style'=>'width:250px','class'=>'form-control input-sm','id'=>'year'])!!}
                            </td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td>Depreciation Rate</td>
                            <td>
                                {!! Form :: text('percentage',null,['style'=>'width:250px','class'=>'form-control input-sm','id'=>'rate','disabled'=>'true'])!!}
                            </td>
                        </tr>
                    </table>
                </div>

                <br>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-info" value="Save Changes" name="delete_attribute">
                </div>
            </div>
        </div>
    </div>
{!! Form ::close() !!}


                                    {{-- Print --}}
<div class="panel-body" name="content12" id="content12" style="display: none">

<div name = "report-header">
        <table width="100%">
            <tr>
                <td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>
                <td width="50%"></td>
            </tr>
            <tr>
                <td width="50%"><h4>Zone24x7 (Private) Limited</h4></td>
                <td width="50%" align="right"><h4>Date : {{date("d-m-Y")}}</h4></td>
            </tr>

            <tr>
                <td width="50%"><h4>Nawala Road,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Koswatte,</h4></td>
                <td></td>
            </tr>

            <tr>
                <td width="50%"><h4>Sri Lanka 10107</h4></td>
                <td></td>
            </tr>

        </table>

        <h2 align="center">Hardware Asset Details</h2>

    </div>

<h3>{{$type}}</h3>
<br>
    <table class="table table-hover" id="hardwareTable">
        <tbody id="tableBody">

        <?php $x = 0;
         $y = 0;?>

        @foreach($columns as $col)

            <?php
               $attribute = $col->table_column;
            ?>

            @if($x == 0)
                <tr>
            @elseif($x % 2 == 0)
                </tr>
                <tr>
            @endif
                <td>
                    {{$col->column_name}}
                </td>
                <td>
                    {{$hardware->$attribute}}
                </td>
                <?php $x++; ?>
        @endforeach

        @if($x % 2 != 0)
            <td></td>
            <td></td>
            </tr>
        @endif
        </tbody>
    </table>

</div>



@endsection
@stop



<script type="text/javascript">
function chk(val)
{
    if(val == 'Straight Line')
    {
        document.getElementById('year').disabled = false;
        document.getElementById('residual').disabled = false;
        document.getElementById('rate').disabled = true;
    }
    else
    {
        document.getElementById('year').disabled = true;
        document.getElementById('residual').disabled = true;
        document.getElementById('rate').disabled = false;
    }
}
</script>


<script>
    function printContent(print_content){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(print_content).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>