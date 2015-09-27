
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

<script>
 var tableToExcel = (function() {
   var uri = 'data:application/vnd.ms-excel;base64,'
     , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
   return function(table, name) {
     if (!table.nodeType) table = document.getElementById(table)
     var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
     window.location.href = uri + base64(format(template, ctx))
   }
 })()
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
margin-left:50px;
}
.btn
    {
    text-align: left;
    }
</style>


<h2 style="color: #9A0000">View Hardware Resources</h2>

<br>

<div class="well">
{!! Form ::open() !!}
<table>
<tr>
    <td>
       <input type="text" name="search_t" class="form-control input-sm" style="width: 200px" placeholder="Search">{{--<label style="width: 100px">Search</label>--}}
    </td>
    <td>
        &nbsp;<button type="submit" name="search" value="search" class="btn btn-primary" style="height: 30px;"><span class="glyphicon glyphicon-search"></span> </button>
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
                @foreach($columns2 as $c)
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
            <select id="existing_attribute" name="existing_attribute[]" class="form-control input-sm" style="width: 180px; min-height: 30px" multiple="multiple" onchange="this.form.submit()">

                @foreach($columns as $col)

                    <?php $sel = false ; ?>
                    @foreach($selectedColumns as $selected)
                        <?php $temp = ($selected == $col->cid) ? true : false;
                            if($temp)
                                $sel = true;
                        ?>
                    @endforeach

                    @if($col->table_column == 'inventory_code')
                        <option value='{{$col->cid}}' selected>{{ $col->column_name }}</option>
                   	@else
                   	    <option value='{{$col->cid}}' @if($sel) selected @endif>{{ $col->column_name }}</option>
                   	@endif

                @endforeach
            </select>
        </td>
</tr>
</table>
{!! Form ::close() !!}
</div>

<div align="right">

    @if($id != 'All')
        <a href="/hardware-report/{{$id}}"><button class="btn btn-warning" style="height: 36px">Advanced Reports</button></a>&nbsp;
    @endif

    <input type="button"  class="btn btn-success" style="height:36px" onclick="tableToExcel('printTable','Inventory')" value="Export to Excel">&nbsp;
    <input type="button"  class="btn btn-primary" style="width:90px; text-align: center" onclick="printContent('content12')" value="Print">&nbsp;

    <br><br>
        <label><b>Max Display Per Page : 30 Items</b></label>

</div>

<div class="span12" style="overflow:auto; min-height: 300px;height: 500px">

<table class="table table-hover" id="hardwareTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">
        @foreach($columns2 as $c)
            <?php $tm = str_replace(' ','&nbsp;', $c->column_name) ?>

            <th>{{$tm}}</th>

        @endforeach
        <th></th>
    </tr>

    <tbody id="tableBody">

    @foreach($hardwares as $hardware)
    @if($hardware->type == $id || $id=='All')
    {!! Form ::open(['method' => 'POST', 'action' => ['ResourceController@editSpecific']]) !!}
    <tr>
        @foreach($columns2 as $col)
        <td>
            <div class="hideextra">
            <?php $attribute = $col->table_column; ?>

            @if($attribute == 'inventory_code')
                <?php $temp1 = urlencode(base64_encode(str_replace('/','-',$hardware->inventory_code)))?>
                        <a href="/hardware-change/{{$temp1}}">{{$hardware->$attribute}}</a>
            @else
                {{$hardware->$attribute}}
            @endif



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
    @endif
    @endforeach

    </tbody>
</table>

</div>


                        {{-- Print --}}

<div id="content12" name="content12" style="display: none">

<div name = "report-header">
        <table width="100%">
            <tr>
                {{--<td width="50%"><img src="/includes/images/zone_logo.png" height="70px" width="200px"></td>--}}
                <td width="50%"><img src="/includes/images/zone_logo.png" height="30px" width="90px"></td>
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

<table class="table table-bordered" id="printTable" cellpadding="0" cellspacing="0" width="100%" style="font-size: 15px;">
    <tr id="headRow" style="background-color: #e7e7e7;">
        @foreach($columns2 as $c)
            <?php $tm = str_replace(' ','&nbsp;', $c->column_name) ?>
            <th>{{$tm}}</th>
        @endforeach
        <th></th>
    </tr>

    <tbody id="tableBody">

    @foreach($hardwares as $hardware)

    <tr>
        @foreach($columns2 as $col)
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

