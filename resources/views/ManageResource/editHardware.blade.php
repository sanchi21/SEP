
@extends('master')

@section('content')
<script type="text/javascript">
                $(document).ready(function() {
                    $('#existing_attribute').multiselect({
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '200px'
                    });
                });
</script>
<style>
.dropdown-menu {
max-height: 370px;
overflow-y: auto;
overflow-x: hidden;
}
.hideextra { white-space: nowrap; overflow: hidden; text-overflow:ellipsis; }
.multiselect-container>li>a>label {
    padding: 0px 20px 0px 10px;
    }

.btn .caret {
margin-left:70px;
}
.btn
    {
    text-align: left;
    }
</style>


<h2 style="color: #9A0000">Hardware Resource</h2>
<div align="right">
&nbsp;<input type="button" onclick="printContent('content12')" class="btn btn-primary" style="height: 30px; width: 70px" value="Print">
</div>
<br>

<div class="well">
{!! Form ::open() !!}
<table>
<tr>
    <td>
       <input type="text" name="search_t" class="form-control input-sm" style="width: 200px" placeholder="Search">{{--<label style="width: 100px">Search</label>--}}
    </td>
    <td>
        &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;"><span class="glyphicon glyphicon-search"></span> </button>
    </td>
    <td>
    &nbsp;&nbsp;&nbsp;
    </td>
    <td>
        <label style="width: 90px">Category</label>
    </td>
    <td>
        <select id="category" name="category" class="form-control input-sm" style="width: 200px" onchange="javascript:location.href = this.value;">
            <option value="/hardware-edit/All" @if($id=="All") selected @endif>All</option>
            @foreach($types as $type)
                <option value='/hardware-edit/{{$type->category}}' @if($id==$type->category) selected @endif>{{ $type->category }}</option>
            @endforeach
        </select>
    </td>

        <td>&nbsp;&nbsp;&nbsp;
            <label style="width: 90px">Sort by</label>
        </td>
        <td>
            <select id="sort" name="sort" class="form-control input-sm" style="width: 200px">
                @foreach($columns as $c)
                    <option value="{{$c->table_column}}" @if($c->table_column==$column) selected @endif>{{$c->column_name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;" name="ascend" value="ascend"><span class="glyphicon glyphicon-chevron-up"></span> </button>
        </td>
        <td>
            &nbsp;<button type="submit" class="btn btn-primary" style="height: 30px;" name="descend" value="descend"><span class="glyphicon glyphicon-chevron-down"></span> </button>
        </td>

        <td>&nbsp;&nbsp;&nbsp;
            <label style="width: 90px">Columns</label>
        </td>
        <td>
            <select id="existing_attribute" name="existing_attribute[]" class="form-control input-sm" style="width: 180px; min-height: 30px" multiple="multiple">
                @foreach($columns as $col)
                    @if($col->table_column != 'inventory_code')
                   	    <option value='{{$col->table_column}}'>{{ $col->column_name }}</option>
                   	@endif
                @endforeach
            </select>
        </td>
</tr>
</table>
{!! Form ::close() !!}
</div>

<div align="right"><label><b>Max Display Per Page : 30 Items</b></label></div>

<div class="span12" style="overflow:auto; min-height: 300px;height: 500px">

<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">
        @foreach($columns as $c)
            <?php $tm = str_replace(' ','&nbsp;', $c->column_name) ?>
            <th>{{$tm}}</th>
        @endforeach
        <th></th>
    </tr>

    <tbody id="tableBody">

    @foreach($hardwares as $hardware)
    {!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@editSpecific']]) !!}
    <tr>
        @foreach($columns as $col)
        <td>
            <div class="hideextra">
            <?php $attribute = $col->table_column; ?>

            {{$hardware->$attribute}}

            @if($attribute == 'inventory_code')
                    <input type="hidden" name="inventory_code" value="{{$hardware->inventory_code}}">
            @elseif($attribute == 'type')
                    {{$hardware->type}} <input type="hidden" name="type" value="{{$hardware->type}}">
            @endif
        </div>
        </td>
        @endforeach

        <td>
        {{--{{str_replace('/','-',$hardware->inventory_code)}}--}}
        <?php $temp = urlencode(base64_encode(str_replace('/','-',$hardware->inventory_code)))?>
        <a href="/hardware-change/{{$temp}}"><input type="button" name="edit" value="Edit" class="btn btn-primary" style="height: 35px; vertical-align: center;width: 60px"></a>
        </td>
    </tr>
    {!! Form ::close() !!}
    @endforeach

    </tbody>
</table>

</div>


                        {{-- Print --}}

<div id="content12" name="content12" style="display: none">

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

        <h2 align="center">{{$id}} Hardware Details</h2>

    </div>
<br>

<table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">
        @foreach($columns as $c)
            <?php $tm = str_replace(' ','&nbsp;', $c->column_name) ?>
            <th>{{$tm}}</th>
        @endforeach
        <th></th>
    </tr>

    <tbody id="tableBody">

    @foreach($hardwares as $hardware)

    <tr>
        @foreach($columns as $col)
        <td>
            <?php $attribute = $col->table_column; ?>

            <label style="font-size: 12px;">{{$hardware->$attribute}}</label>

            @if($attribute == 'inventory_code')
                    <input type="hidden" name="inventory_code" value="{{$hardware->inventory_code}}">
            @elseif($attribute == 'type')
                    {{$hardware->type}} <input type="hidden" name="type" value="{{$hardware->type}}">
            @endif
        </td>
        @endforeach

    </tr>

    @endforeach

    </tbody>
</table>
</div>




<div align="center">
    {!!$hardwares->render()!!}
    </div>
@endsection
@stop

<script>
    function printContent(print_content){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(print_content).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>