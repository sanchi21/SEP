@extends('master')

@section('content')

<h3></h3>

<div align="right">
<input type="button" onclick="printContent('content12')" class="btn btn-primary" value="Print">&nbsp;&nbsp;
</div>

<div class="panel-body">


<table class="table table-hover" id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
            <tbody>

            <th>Inventory Code</th>
                            <th>Type</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Allocated To</th>

                    @foreach($allocations as $all)

                            <tr>
                               {{--<td>{{$all->request_id}}</td>--}}
                               {{--<td>{{$all->sub_id}}</td>--}}

                                {!! Form ::open(['method' => 'POST', 'url' => 'releaseResourceEmployee']) !!}




                                     <td>{{$all->inventory_code}}</td>
                                     <td>{{$all->resource_type}}</td>
                                     <td>{{$all->make}}</td>
                                     <td>{{$all->model}}</td>
                                     <td>{{$all->user_name}}</td>


                                       <input type="hidden" value="{{$all->inventory_code}}" name="inventory">

                                {!! Form::close() !!}


                              </td>
                              </tr>

                            @endforeach




            </tbody>
            </table>

</div>


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

        <h2 align="center">Report title</h2>

    </div>

<table class="table table-hover" id="search" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff">
            <tbody>

            <th>Inventory Code</th>
                            <th>Type</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Allocated To</th>

                    @foreach($allocations as $all)

                            <tr>
                               {{--<td>{{$all->request_id}}</td>--}}
                               {{--<td>{{$all->sub_id}}</td>--}}

                                {!! Form ::open(['method' => 'POST', 'url' => 'releaseResourceEmployee']) !!}




                                     <td>{{$all->inventory_code}}</td>
                                     <td>{{$all->resource_type}}</td>
                                     <td>{{$all->make}}</td>
                                     <td>{{$all->model}}</td>
                                     <td>{{$all->user_name}}</td>


                                       <input type="hidden" value="{{$all->inventory_code}}" name="inventory">

                                {!! Form::close() !!}


                              </td>
                              </tr>

                            @endforeach




            </tbody>
            </table>

</div>
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