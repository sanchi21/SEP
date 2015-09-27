<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 25/9/2015
 * Time: 4:05 PM
 */
 ?>

@extends('master')
@section('content')

    <script type="text/javascript">

                $(document).ready(function() {
                    $('#user').multiselect({
                    enableFiltering: true,
                    buttonWidth: '350px'
                    });
                });
    </script>

    <div class="panel panel-default" style="width:100%">

    <div class="panel-heading" style="color: #9A0000"><h4>Available And Allocated Resources</h4></div>

    <div class="panel-body">

        <input type="button" class="btn btn-primary form-control" style="float: right;width:50px"  value="Print" onclick="printAllocation('data','chartContainer','header')"></button>

        </br>

        <form action="{{ URL::route('ViewAllocationGraph') }}" method="post">

        </br>

        <table class="table table-hover-l" >

            <tr>

                <td width="20%"><b>Hardware Resource</b></td>

                <td width="40%">

                <select class="form-control" name="items" style="width: 100%">

                    @foreach($hardwareItems as $item)

                        <option>

                            {{$item->category}}

                        </option>

                    @endforeach

                </select>

                </td>

                <td width="50%"><button type="submit" class="btn btn-primary" style="height: 32px;" name="view" id="view"><span class="glyphicon glyphicon-check"></span> </button></td>


            </tr>

        </table>

        {!! Form::token() !!}

        </form>

        <div id="data" style="float: left; width: 50%">

            @if($selectedItem !="")

                <h4><b>Type&nbsp;:&nbsp;{{$selectedItem}}</b></h4>

                @if($getDevicesAllocated != null)

                    </br>

                    <h4 style="color: #9A0000"><b>Allocated Hardware Resources&nbsp;&nbsp;{{$allocationCount}}</b></h4

                    </br>

                    @if( $allocationCount !=0)

                    <table class="table table-hover-l">

                        <tr>

                            <th>Inventory Code</th>
                            <th>Description</th>
                            <th>Make</th>
                            <th>Purchase Date</th>

                        </tr>

                        @foreach($getDevicesAllocated as $allocated)

                        <tr>

                            <td>{{$allocated->inventory_code}}</td>
                            <td>{{$allocated->description}}</td>
                            <td>{{$allocated->make}}</td>
                            <td>{{$allocated->purchase_date}}</td>


                        </tr>

                        @endforeach

                    </table>

                    @endif

                @endif

                @if($getDevicesNotAllocated != null && $notAllocatedCount !=0)

                    </br>

                    <h4 style="color: #0088cc"><b>Available Hardware Resources&nbsp;&nbsp;{{$notAllocatedCount}}</b></h4>

                    </br>

                    @if( $notAllocatedCount !=0)

                    <table class="table table-hover-l">

                        <tr>

                            <th>Inventory Code</th>
                            <th>Description</th>
                            <th>Make</th>
                            <th>Purchase Date</th>

                        </tr>

                        @foreach($getDevicesNotAllocated as $not_allocated)

                        <tr>

                            <td>{{$not_allocated->inventory_code}}</td>
                            <td>{{$not_allocated->description}}</td>
                            <td>{{$not_allocated->make}}</td>
                            <td>{{$not_allocated->purchase_date}}</td>


                        </tr>

                        @endforeach

                    </table>

                    @endif

                 @endif

            @endif


        </div>

        <div id="chartContainer" style="float: right; width: 45%"></div>

        <div id="header" style="display: none;">

            <table width="100%">

                <tr>

                     <td width="50%">
                     <img src="/includes/images/zone_logo.png" height="70px" width="200px">
                     </td>

                     <td width="50%"></td>

                </tr>

                <tr>

                    <td width="50%">
                    <h4>Zone24x7 (Private) Limited</h4>
                    </td>

                    <td width="50%" align="right">
                    <h4>Date : {{date("d-m-Y")}}</h4>
                    </td>

                </tr>

                <tr>

                    <td width="50%">
                    <h4>Nawala Road,</h4>
                    </td>

                    <td></td>

                </tr>

                <tr>

                    <td width="50%">
                    <h4>Koswatte,</h4>
                    </td>

                    <td></td>

                </tr>

                <tr>

                    <td width="50%">
                    <h4>Sri Lanka 10107</h4>
                    </td>

                    <td></td>

                </tr>

            </table>

            <h2 align="center">Available and Allocated Hardware Resources</h2>

            </br>

            <h4>This report contains a summarized history of each and individual hardware resources </h4>
            </br>

        </div>


    </div>
    </div>



<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>


<script >

@if($allocationCount !="" || $notAllocatedCount!="")

 Morris.Donut({
           element: 'chartContainer',
           data: [

                 {label: "Allocated"  , value:'{{$allocationCount}}'},
                 {label: "Available", value: '{{$notAllocatedCount}}'},
           ],
           colors: [

               '#8C001A',
               '#38ACEC'

             ]
         });
@endif

</script>

<script>

        function printAllocation(data,chartContainer,header){

               var restorepage = document.body.innerHTML;
               var printcontent = document.getElementById(data).innerHTML;
               var printcontent1 = document.getElementById(chartContainer).innerHTML
               var printcontent2 = document.getElementById(header).innerHTML
               var value= printcontent.concat(printcontent1);
               document.body.innerHTML = printcontent2.concat(value);
               window.print();
               document.body.innerHTML = restorepage;
           }

</script>


@endsection