@extends('master')

@section('content')

<br>
<br>
<h2 style="color: #9A0000">Add Resource Portions</h2>

<br>
<br>

<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Operating Systems</div>
              <div class="panel-body">
                    {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addOS']]) !!}
                    <input type="text" name="os_name" class="form-control input-sm" value="" style="width: 120px">
                    <input type="submit" name="add" class="btn btn-primary" value="Add&nbsp;">
                    {!! Form::close() !!}


                        <table class="table table-hover" id="operatingSystem">
                        @foreach($operatingSystems as $OS)
                             <tr>
                                 <td>
                                 {!! Form ::open(['method' => 'POST', 'url' => 'updateOS']) !!}
                                 <input type="text" name="os_name" class="form-control input-sm" value="{{$OS->OS_Name}}" style="width: 120px">&nbsp;<a class="btn btn-default" name="deleteOS" href="delete/OS/{{$OS->id}}">Delete</a>
                                 &nbsp; <input type="submit" name="updateOS" value="Save">
                                 <input type="hidden" name="OS_id" value="{{$OS->id}}">
                                 {!! Form::close() !!}
                                 </td>
                             </tr>
                        @endforeach
                        </table>
                        <div> {!!$operatingSystems->render()!!}</div>


              </div>
        </div>

    </div>

    <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Make</div>
                  <div class="panel-body">
                        {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addMake']]) !!}
                        <input type="text" name="make_name" class="form-control input-sm" value="" style="width: 120px">
                        <input type="submit" name="add_make" class="btn btn-primary" value="Add&nbsp;">
                        {!! Form::close() !!}


                            <table class="table table-hover" id="Make">
                            @foreach($makes as $make)
                                 <tr>
                                     <td>
                                         {!! Form ::open(['method' => 'POST', 'url' => 'updateMake']) !!}
                                         <input type="text" name="make_name" class="form-control input-sm" value="{{$make->Make_Name}}" size="50px">&nbsp; <a class="btn btn-default" name="deleteMake" href="delete/make/{{$make->id}}">Delete</a>
                                         &nbsp; <input type="submit" name="updateMake" value="Save">
                                         <input type="hidden" name="make_id" value="{{$make->id}}">
                                         {!! Form::close() !!}
                                     </td>
                                 </tr>
                            @endforeach
                            </table>
                  </div>
            </div>

        </div>


        <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Screen Size</div>
                          <div class="panel-body">
                                {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addScreen']]) !!}
                                <input type="text" name="provider_name" class="form-control input-sm" value="" style="width: 120px">
                                <input type="submit" name="add_provider" class="btn btn-primary" value="Add&nbsp;">
                                {!! Form::close() !!}


                                    <table class="table table-hover" id="ScreenSize">
                                    @foreach($sizes as $size)
                                         <tr>
                                             <td>
                                                 {!! Form ::open(['method' => 'POST', 'url' => 'updateScreen']) !!}
                                                 <input type="text" name="providerName" class="form-control input-sm" value="{{$size->Screen_Size}}" style="width: 120px">&nbsp; <a class="btn btn-default" name="deleteScreen" href="delete/screen/{{$size->id}}">Delete</a>
                                                 &nbsp; <input type="submit" name="updateScreen" value="Save">
                                                 <input type="hidden" name="screen_id" value="{{$size->id}}">
                                                 {!! Form::close() !!}
                                             </td>
                                         </tr>
                                    @endforeach
                                    </table>
                          </div>
                    </div>

         </div>

         <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Service Provider</div>
                                  <div class="panel-body">
                                        {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addProvider']]) !!}
                                        <input type="text" name="provider_name" class="form-control input-sm" value="" style="width: 120px">
                                        <input type="submit" name="add_provider" class="btn btn-primary" value="Add&nbsp;">
                                        {!! Form::close() !!}


                                            <table class="table table-hover" id="ServiceProvider">
                                            @foreach($providers as $provider)
                                                 <tr>
                                                     <td>
                                                         {!! Form ::open(['method' => 'POST', 'url' => 'updateProvider']) !!}
                                                         <input type="text" name="ProviderName" class="form-control input-sm" value="{{$provider->Provider_Name}}" style="width: 120px">&nbsp; <a class="btn btn-default" name="deleteScreen" href="delete/provider/{{$provider->id}}">Delete</a>
                                                         &nbsp; <input type="submit" name="updateProvider" value="Save">
                                                         <input type="hidden" name="provider_id" value="{{$provider->id}}">
                                                         {!! Form::close() !!}
                                                     </td>
                                                 </tr>
                                            @endforeach
                                            </table>
                                  </div>
                            </div>

                 </div>




@stop