@extends('master')

@section('content')
<?php header('Refresh: 20'); ?>
<h3 style="color: #354b60">Dashboard | Automatic Resource Allocation</h3>
<div style="float: left; vertical-align: top; width: 54%">
<table style="width: 100%">
    <tr>
        <td style="width: 4px"></td>

        <td background = "{{asset('/includes/images/dashboardIcons/projectManager/dashboardIcons1.jpg')}}"  style="width: 346px;height: 167px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 43px">
            <b>
                    {{ $countPendingResourceRequests }}
                    <p style="font-size: 20px; opacity: 0.7">Pending Requests</p>
            </b>
        </td>
        <td style="width: 20px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/projectManager/dashboardIcons3.jpg')}}"  style="width: 346px;height: 167px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 43px">
            <b>
                    {{ $countAcceptedRequests }}
                    <p style="font-size: 20px; opacity: 0.7">Accepted Requests</p>
            </b>
        </td>
        <tr>
        <td><br></td>
        <td><br></td>
        </tr>
        <tr>
        <td style="width: 4px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/projectManager/dashboardIcons2.jpg')}}" style="width: 346px;height: 167px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 43px">
            <b>
                {{ $countPendingRenewal }}
                <p style="font-size: 20px; opacity: 0.7">Pending Renewal</p>

            </b>
        </td>

        <td style="width: 4px"></td>
        <td background = "{{asset('/includes/images/dashboardIcons/projectManager/dashboardIcons5.jpg')}}"  style="width: 346px;height: 167px; background-repeat: no-repeat; padding-left:5px; color: white; font-size: 43px">
            <b>
                    {{ $countAcceptedRenewal }}
                    <p style="font-size: 20px; opacity: 0.7">Accepted Renewal</p>
            </b>
        </td>
        </tr>

</table>
</div>

<div style="float: right; width: 45%; vertical-align: top">
<table style="width: 100%">
<tr>
<td>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#ResourceStatus" aria-controls="home" role="tab" data-toggle="tab"><p style="font-size: 12px"><span class="glyphicon glyphicon-tasks"></span> Resource Status </p> </a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="ResourceStatus">
        <?php

        foreach ($requests as $request)
        {
               $start = strtotime($request -> required_from);
               $end =  strtotime($request -> required_upto);
               $now = strtotime("now");
               if($start!=$end)
               {
                   $finishedDays = ($now-$start)/(60*60*24);


                   $total =  ($end-$start)/(60*60*24);
                   $progress = ($finishedDays/$total)*100;
                   $remainingDays = ($total-$finishedDays);
                   if ($request->item!=NULL)
                   {
                        $resourceType = 'HARDWARE';
                        $object = $request->item;
                   }
                   else
                   {
                        $resourceType = 'SOFTWARE';
                        $object = $request->device_type;
                   }
                   }
               else
               {
                echo 'expired';
               }

        ?>
        <p style="font-size: 12px">
        <b><i>Project ID:</i></b> {{ $request->project_id }}<br>
        <b><i>Resource Type:</i></b> {{ $resourceType }}<br>
        <b><i>Resource:</i></b>{{$object}}

        @if($remainingDays <= 0)
        <b><u>[resource expired]</b></u>
        @elseif($remainingDays < 2)
        <b><u>[{{round($remainingDays+1)}} one more day available]</b></u>
        @else
        <b><u>[{{round($remainingDays)+1}} more days available]</b></u>
        @endif

        @if($progress<80)
            <div class="progress">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress;?>%">
                    <span class="sr-only">60% Complete</span>
                  </div>
            </div>
        @else
        <div class="progress">
                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress;?>%">
                    <span class="sr-only">60% Complete</span>
                  </div>
            </div>
        @endif
        </p>

        <?php
        }
        ?>
        </div>
    </div>
</td>
<td>

</td>
<td>

</td>
<td>

</td>
</tr>
</table>

<br>



@endsection



