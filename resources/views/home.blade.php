@extends('master')

@section('content')
<?php header('Refresh: 20'); ?>
<h3 style="color: #354b60">Dashboard | Automatic Resource Allocation</h3>

<table style="width: 100%">
    <tr>
        <td style="width: 40px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/dashboardIcons1.jpg')}}"  style="width: 243px;height: 120px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 33px">
            <b>
                    {{ $countPendingResourceRequests }}
                    <p style="font-size: 14px; opacity: 0.7">New Requests</p>
            </b>
        </td>
        <td style="width: 4px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/dashboardIcons3.jpg')}}"  style="width: 243px;height: 120px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 33px">
            <b>
                    {{ $countTotalAvailableResources }}
                    <p style="font-size: 14px; opacity: 0.7"><a href=" {{ URL::route('hardware-edit-get') }}" style="color: white">Available Resources</a></p>

            </b>
        </td>
        <td style="width: 4px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/dashboardIcons2.jpg')}}" style="width: 243px;height: 120px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 33px">
            <b>
                {{ $countSystemUsers }}
                <p style="font-size: 14px; opacity: 0.7"><a href=" {{ URL::route('add-user') }}" style="color: white">User Registration</a></p>

            </b>
        </td>
        <td style="width: 4px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/dashboardIcons6.jpg')}}"  style="width: 243px;height: 120px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 33px">
            <b>
                    {{ $countPendingRenewalRequests }}
                    <p style="font-size: 14px; opacity: 0.7">Renewal Requests</p>
            </b>
        </td>
        <td style="width: 4px"></td>

    </tr>
</table>
<br>
<div>

    <table style="width: 100%">

        <tr>
            <td style="width: 40; vertical-align: top">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#graph" aria-controls="home" role="tab" data-toggle="tab"><p style="font-size: 12px"><span class="glyphicon glyphicon-signal"></span> No of Resources </p> </a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="graph">
                     <canvas id='statistic' style="width:100%; height:300"></canvas>
                </div>
            </div>

            </td>
            <td style="width: 1%"></td>
            <td style="width: 24%; vertical-align: top">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#ResourceStatus" aria-controls="home" role="tab" data-toggle="tab"><p style="font-size: 12px"><span class="glyphicon glyphicon-cd"></span> Resource analysis </p> </a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="ResourceStatus">
                        <table>
                        <tr>
                        <td><canvas id='statistic_2' style="width:100%; height:300"></canvas></td>
                        <td><canvas id='statistic_3' style="width:100%; height:300"></canvas></td>
                        </tr>
                        <tr style="font-size: 12px">
                        <td style="text-align: center"><i>Hardware</i></td>
                        <td style="text-align: center"><i>Software</i></td>
                        </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td style="width: 1%"></td>
            <td style="width: 34%; vertical-align: top">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#RecentRequests" aria-controls="home" role="tab" data-toggle="tab"><p style="font-size: 12px"><span class="glyphicon glyphicon-th-list"></span> Recent Requests </p> </a></li>
                </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="RecentRequests">
                    <table class="table table-striped" style="font-size: 12px">
                      <tr>
                        <th>Date</th>
                        <th>Owner</th>
                        <th>Required From</th>
                        <th>Required Upto</th>
                      </tr>
                      @foreach($recentRequests as $recentRequest)
                      <tr>
                        <td>{{$recentRequest->assigned_date}}</td>
                        <td>{{$recentRequest->username}}</td>
                        <td>{{ $recentRequest->required_from }}</td>
                        <td>{{ $recentRequest->required_upto }}</td>

                      </tr>
                      @endforeach

                    </table>
                </div>

              </div>
            </td>
        </tr>
    </table>
</div>
@endsection


 @section('footer')
    <script src="/includes/js/draw.min.js"></script>

    <script>
        (function(){
            var ctx = document.getElementById('statistic').getContext('2d');
            var chart = {
                labels:['communication','desktop','laptop','monitor'],
                datasets:[ {


                                      {{--label: {{ json_encode($hardwareTypes)}},--}}
                                      fillColor: "rgba(151,187,205,0.2)",
                                      strokeColor: "rgba(151,187,205,1)",
                                      pointColor: "rgba(151,187,205,1)",
                                      pointStrokeColor: "#fff",
                                      pointHighlightFill: "#fff",
                                      pointHighlightStroke: "rgba(151,187,205,1)",
                                      data: [12, 20, 25, 10]
                                  }]
            };
            new Chart(ctx).Bar(chart);
        })();

        (function(){
             var ctx = document.getElementById('statistic_2').getContext('2d');
                var chart = [
                    {
                         value: {{ json_encode($countAllocatedHardware)}},
                         color: "#ffdf60",
                         highlight: "#ffce0a",
                         label: "Allocated"
                    },
                    {
                         value: {{ json_encode($countPendingHardwares)}},
                         color: "#66cc00",
                         highlight: "#ffffff",
                         label: "Requested"
                    },
                    {
                        value: {{ json_encode($countAvailableHardware) }},
                        color: "#52a400",
                        highlight: "#52a400",
                        label: "Available"
                    }
                ]
                 //new Chart(ctx).Doughnut(chart);
                 new Chart(ctx).Doughnut(chart);
                })();

        (function(){
             var ctx = document.getElementById('statistic_3').getContext('2d');
                var chart = [
                      {
                            value: {{ json_encode($countAllocatedSoftware)}},
                            color: "#ffdf60",
                            highlight: "#ffce0a",
                            label: "Allocated"
                      },
                      {
                            value: {{ json_encode($countPendingSoftwares)}},
                            color: "#66cc00",
                            highlight: "#ffce0a",
                            label: "Requested"
                      },
                      {
                            value: {{ json_encode($countAvailableSoftware) }},
                            color: "#52a400",
                            highlight: "#52a400",
                            label: "Available"
                      }
                ]
                 //new Chart(ctx).Doughnut(chart);
                 new Chart(ctx).Doughnut(chart);
        })();
    </script>
 @stop
