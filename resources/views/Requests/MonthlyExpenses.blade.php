<?php
/**
 * Created by PhpStorm.
 * User: SrinithyPath
 * Date: 26/9/2015
 * Time: 3:17 PM
 */
?>

 @extends('master')
 @section('content')

 <div class="panel panel-default" style="width: 100%">

    <div class="panel-heading" style="color: #9A0000"><h2>Monthly Expenditure</h2></div>

        <div class="panel-body">

        <form action="{{ URL::route('ViewMonthlyExpenses') }}" method="post">

        <input type="button" class="btn btn-primary form-control" style="float: right;width:50px"  value="Print" onclick="printAllocation('order','maintenance','total','header','chartContainer')"></button></br>

        </br>

        <table class="table table-hover-l" style="width: 100%">

            <tr>

                <td width="15%"><b>Select Month-Year</b></td>

                <td>

                      <select class="form-control" name="month">
                              <option value="01">January</option>
                              <option value="02">February</option>
                              <option value="03">March</option>
                              <option value="04">April</option>
                              <option value="05">May</option>
                              <option value="06">June</option>
                              <option value="07">July</option>
                              <option value="08">August</option>
                              <option value="09">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>

                      </select>

                </td>

                <td>

                    <select class="form-control" name="year">

                        <?PHP
                            $year = date("Y") - 8; for ($i = 0; $i <= 8; $i++) {echo "<option>$year</option>"; $year++;}
                        ?>
                    </select>


                </td>

                <td>

                    <button type="submit" class="btn btn-primary" style="height: 32px;" name="view" id="view"><span class="glyphicon glyphicon-check"></span> </button>

                </td>

            </tr>

        </table>

        {!! Form::token() !!}

        </form>


        <div id="order" style="float: left; width: 45%">

            @if($total != null)

            <h4 style="color: #9A0000"><b>Procurement Order Cost</b></h4></br>

            <table class="table table-hover-l" style="font-size: medium;font-family: Arial;width: 100%">

            <tr>

                <th>Procurement Request</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Total</th>

            </tr>

            <?php $a=0;  ?>

            @foreach($total as $tot)

            <tr>

                <td>{{$requestId[$a]}}</td>
                <td>{{$orderDate[$a]}}</td>
                <td>{{$paymentMethod[$a]}}</td>
                <td>{{$total[$a]}}</td>

            </tr>

            <?php $a++;  ?>

            @endforeach

            </table>

            </br>

            <table class="table table-hover-l" style="font-size: medium;font-family: Arial;width: 100%">

                <tr>

                    <td><b>Total Order Cost</b></td>
                    <td></td>
                    <td width="58%"></td>
                    <td><b>{{$totalCost}}</b></td>

                </tr>


            </table>

            @endif

        </div>


        <div id="maintenance" style="float: right; width:48%">

            @if( $cost != null)

             <h4 style="color: #9A0000"><b>Maintenance Cost</b></h4></br>

            <table class="table table-hover-l" style="font-size: medium;font-family: Arial;width: 100%">

                <tr>

                    <th>Remarks</th>
                    <th>Date</th>
                    <th>Cost</th>

                </tr>

                <?php $b=0;  ?>

                @foreach($cost as $c)

                <tr>

                    <td>{{$remarks[$b]}}</td>
                    <td>{{$mainDate[$b]}}</td>
                    <td>{{$cost[$b]}}</td>

                </tr>

                <?php $b++;  ?>

                @endforeach


            </table>

            </br>

            <table class="table table-hover-l" style="font-size: medium;font-family: Arial;width: 100%">

                <tr>

                    <td><b>Total Maintenance Cost</b></td>
                    <td width="10%"></td>
                    <td><b>{{$totalCostMain}}</b></td>

                </tr>


            </table>

            @endif

        </div>

    </div>


    @if($totalCost !="" || $totalCostMain !="")

         <div id="total" style="float: left; width: 45%;height: 5%">

               <?php $totalSum=$totalCost + $totalCostMain ?>

                  </br></br></br>

               <h4><b>&nbsp;&nbsp;Total Monthly Expenditure&nbsp;:&nbsp;{{$totalSum}}</b></h4>

         </div>

    @endif

    <div id="chartContainer" style=" float: right;width: 75%" ></div>


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


    </div>



 </div>

 <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>


 <script >

 {{--@if( $totalCost != "" || $totalCostMain != "" )--}}

  Morris.Donut({
            element: 'chartContainer',
            data: [

                  {label: "Order"  , value:'{{$totalCost}}'},
                  {label: "Maintenance", value: '{{$totalCostMain}}'},
            ],
            colors: [

                '#0B0B61',
                '#38ACEC'

              ]
          });
 {{--@endif--}}

 </script>

<script>

        function printAllocation(order,maintenance,total,header,chartContainer){

               var restorepage = document.body.innerHTML;
               var printcontent = document.getElementById(order).innerHTML;
               var printcontent1 = document.getElementById(maintenance).innerHTML
               var printcontent2 = document.getElementById(total).innerHTML
               var printcontent3 = document.getElementById(header).innerHTML
               var printcontent4= document.getElementById(chartContainer).innerHTML
               var value= printcontent3.concat(printcontent);
               var value1= printcontent1.concat(printcontent2);
               var value2= value1.concat(printcontent4);
               document.body.innerHTML = value.concat(value2);
               window.print();
               document.body.innerHTML = restorepage;
           }

</script>

<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>


  @endsection