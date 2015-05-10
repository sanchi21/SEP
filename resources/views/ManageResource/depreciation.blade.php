
@extends('master')

@section('content')
<h2 style="color: #9A0000">Asset Depreciation</h2>
<br>

<br>

<div class="container">

    <table width="100%">
        <tr>
            <td valign="top" width="40%">
                    <table class="table table-striped" style="color: #9A0000">
                        <tr>
                            <td><strong>Inventory&nbsp;Code</strong></td>
                            <td>{{$hardware->inventory_code}}</td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td><strong>Category</strong></td>
                            <td>{{$hardware->type}}</td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>

                        <tr>
                            <td><strong>Value</strong></td>
                            <td>{{$hardware->value}}</td>
                        </tr>

                    <br>
                    </table>
            </td>

            <td width="10%">
                &nbsp;&nbsp;&nbsp;
            </td>

            <td width="50%">

                <div  style="width:500px">
                    <table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="70%" style="font-size: 15px;">
                        <tr id="headRow" style="background-color: #e7e7e7;">
                            <th>Year</th>
                            <th>Depreciation</th>
                            <th>Book&nbsp;Value</th>
                        </tr>

                        <tbody id="tableBody">
                        <?php $x=0; ?>
                            @foreach($depreciate as $year => $value)
                            <tr>
                                <td width="20%">
                                    {{$year}}
                                </td>

                                <td width="40%">
                                    {{$dVal[$x]}}
                                </td>

                                <td width="40%">
                                    {{$value}}
                                </td>
                            </tr>
                        <?php $x++ ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div align="right">
        <input type="button" onclick="printContent('content12')" class="btn btn-primary" value="Print">&nbsp;&nbsp;
    </div>
</div>



                            {{-- Print --}}

<div class="container" name="content12" id="content12" style="display: none">

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

        <h2 align="center">Hardware Asset Valuation</h2>

    </div>
<br>
    <table width="100%">
        <tr>
            <td width="50%"><h5>Inventory Code</h5></td>
            <td><h5>{{$hardware->inventory_code}}</h5></td>
        </tr>

        <tr>
            <td width="50%"><h5>Category</h5></td>
            <td><h5>{{$hardware->type}}</h5></td>
        </tr>

        <tr>
            <td width="50%"><h5>Value</h5></td>
            <td><h5>{{$hardware->value}}<h5></td>
        </tr>
    </table>

<br>

        <div  style="width:500px">
            <table class="table table-bordered" id="hardwareTable" cellpadding="0" cellspacing="0" width="70%" style="font-size: 15px;">
                <tr id="headRow" style="background-color: #e7e7e7;">
                    <th>Year</th>
                    <th>Depreciation</th>
                    <th>Book&nbsp;Value</th>
                </tr>

                <tbody id="tableBody">
                <?php $x=0; ?>
                @foreach($depreciate as $year => $value)
                    <tr>
                        <td width="20%">
                            {{$year}}
                        </td>

                        <td width="40%">
                            {{$dVal[$x]}}
                        </td>

                        <td width="40%">
                            {{$value}}
                        </td>
                    </tr>

                <?php $x++ ?>
                @endforeach

                </tbody>
            </table>
        </div>
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