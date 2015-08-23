@extends('...master')

@section('content')

<style>
div.scroll {

    height: 300px;
    overflow: scroll;

}
</style>

<br>
<h2 style="color: #9A0000">Configure Options</h2>

<br>
<br>

<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Operating Systems</div>
            <div class="scroll">
              <div class="panel-body">

                    {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addOS']]) !!}
                    <div class="row">
                        <div class="col-lg-9">
                        <input type="text" name="os_name" class="form-control input-sm" value="" style="width: 300px">
                        </div>
                        <div class="col-lg-3">
                        <input type="submit" name="add" class="btn btn-primary" value="Add&nbsp;">

                        </div>
                    </div>
                    <span class="help-block alert-danger width:" style="width:300px">{{ $errors->first('os_name') }}</span>
                    {!! Form::close() !!}

                    <br>
                        <table class="table table-hover" id="operatingSystem">
                        @foreach($operatingSystems as $OS)
                             <tr>
                                 <td>
                                 {!! Form ::open(['method' => 'POST', 'url' => 'updateOS']) !!}
                                 <input type="text" name="osName" class="form-control input-sm" value="{{$OS->OS_Name}}" style="width: 300px">
                                 </td>
                                 <td>
                                 &nbsp;<a class="btn btn-default" name="deleteOS" href="delete/OS/{{$OS->id}}">Delete</a>
                                  </td>
                                  <td>
                                 <input class="btn btn-default" type="submit" name="updateOS" value="Save">
                                 </td>
                                 <input type="hidden" name="OS_id" value="{{$OS->id}}">
                                 {!! Form::close() !!}
                                  @if ($errors->first('osName'))
                                {{Session::flash('flash_message_error',$errors->first('osName'))}}
                                 @endif

                             </tr>
                        @endforeach
                        </table>
                        {{--<div> {!!$operatingSystems->render()!!}</div>--}}


              </div>
        </div>
        </div>

    </div>
<style>
.panel-default {
  border-color: #e7e7e7;
}

.panel-default>.panel-heading {
            background-color: #e7e7e7;
            border-bottom-color: #e7e7e7;
            color: #000000;
            font: bold;
            font-size: 18px;
       }</style>
    <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Make</div>

                <div class="scroll">
                  <div class="panel-body">

                        {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addMake']]) !!}
                        <div class="row">
                        <div class="col-lg-9">
                        <input type="text" name="make_name" class="form-control input-sm" value="" style="width: 300px">
                        </div>
                        <div class="col-lg-3">

                        <input type="submit" name="add_make" class="btn btn-primary" value="Add&nbsp;">

                        </div>
                        </div>
                        <span class="help-block alert-danger" style="width:300px">{{ $errors->first('make_name') }}</span>
                        {!! Form::close() !!}

                        <br>


                        <table class="table table-hover" id="Make">
                        @foreach($makes as $make)
                             <tr>
                                    <td>
                                     {!! Form ::open(['method' => 'POST', 'url' => 'updateMake']) !!}
                                     <input type="text" name="makeName" class="form-control input-sm" value="{{$make->Make_Name}}" size="300px">
                                     </td>
                                     <td>
                                     <a class="btn btn-default" name="deleteMake" href="delete/make/{{$make->id}}">Delete</a>
                                     </td>
                                     <td>
                                     <input class="btn btn-default" type="submit" name="updateMake" value="Save">
                                     </td>

                                     <input class="hidden" name="make_id" value="{{$make->id}}">
                                     {!! Form::close() !!}
                                      @if ($errors->first('makeName'))
                                     {{Session::flash('flash_message_error',$errors->first('makeName'))}}
                                      @endif


                                 </tr>
                            @endforeach
                            </table>

                            {{--<div> {!!$makes->render()!!}</div>--}}

                            </div>
                    </div>
                  </div>
            </div>


        </div>


        <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Screen Size</div>
                          <div class="scroll">
                          <div class="panel-body">
                                {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addScreen']]) !!}
                                <div class="row">
                                <div class="col-lg-9">
                                <input type="text" name="screen_size" class="form-control input-sm" value="" style="width: 250px">
                                </div>
                                <div class="col-lg-3">
                                <input type="submit" name="addScreen" class="btn btn-primary" value="Add&nbsp;">
                                </div>
                                </div>
                                <span class="help-block alert-danger" style="width:300px">{{ $errors->first('screen_size') }}</span>
                                {!! Form::close() !!}
                                <br>


                                    <table class="table table-hover" id="ScreenSize">
                                    @foreach($sizes as $size)
                                         <tr>
                                                <td>
                                                 {!! Form ::open(['method' => 'POST', 'url' => 'updateScreen']) !!}
                                                 <input type="text" name="screenName" class="form-control input-sm" value="{{$size->Screen_Size}}" style="width: 300px">
                                                 </td>
                                                 <td>
                                                 <a class="btn btn-default" name="deleteScreen" href="delete/screen/{{$size->id}}">Delete</a>
                                                 </td>
                                                 <td>
                                                 <input class="btn btn-default" type="submit" name="updateScreen" value="Save">
                                                 </td>
                                                 <input type="hidden" name="screen_id" value="{{$size->id}}">
                                                 {!! Form::close() !!}
                                                 @if($errors->first('screenName'))
                                                  {{Session::flash('flash_message_error',$errors->first('screenName'))}}
                                                   @endif

                                         </tr>
                                    @endforeach
                                    </table>

                                    {{--<div> {!!$sizes->render()!!}</div>--}}
                          </div>
                    </div>
                    </div>

         </div>

         <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Service Provider</div>
                                <div class="scroll">
                                  <div class="panel-body">
                                        {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addProvider']]) !!}
                                        <div class="row">
                                        <div class="col-lg-9">
                                        <input type="text" name="provider_name" class="form-control input-sm" value="" style="width: 250px">
                                        </div>
                                        <div class="col-lg-3">
                                        <input type="submit" name="add_provider" class="btn btn-primary" value="Add&nbsp;">
                                        </div>
                                        </div>
                                        <span class="help-block alert-danger" style="width:300px">{{ $errors->first('provider_name') }}</span>
                                        {!! Form::close() !!}
                                        <br>


                                            <table class="table table-hover" id="ServiceProvider">
                                            @foreach($providers as $provider)
                                                 <tr>
                                                        <td>
                                                         {!! Form ::open(['method' => 'POST', 'url' => 'updateProvider']) !!}
                                                         </td>
                                                         <td>
                                                         <input type="text" name="ProviderName" class="form-control input-sm" value="{{$provider->Provider_Name}}" style="width: 300px">
                                                          </td>
                                                          <td>
                                                          <a class="btn btn-default" name="deleteScreen" href="delete/provider/{{$provider->id}}">Delete</a>
                                                         </td>
                                                         <td>
                                                         <input class="btn btn-default" type="submit" name="updateProvider" value="Save">
                                                         </td>
                                                         <input type="hidden" name="provider_id" value="{{$provider->id}}">
                                                         {!! Form::close() !!}
                                                          @if ($errors->first('ProviderName'))
                                                         {{Session::flash('flash_message_error',$errors->first('ProviderName'))}}
                                                        @endif

                                                 </tr>
                                            @endforeach
                                            </table>

                                            {{--<div> {!!$providers->render()!!}</div>--}}
                                  </div>
                            </div>

                        </div>

                 </div>

                 <div class="col-md-6">
                             <div class="panel panel-default">
                                 <div class="panel-heading">Ram Size</div>
                                 <div class="scroll">
                                   <div class="panel-body">
                                         {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addRam']]) !!}
                                          <div class="row">
                                         <div class="col-lg-9">
                                         <input type="text" name="ram_size" class="form-control input-sm" value="" style="width: 220px">
                                         </div>
                                         <div class="col-lg-3">
                                         <input type="submit" name="addRam" class="btn btn-primary" value="Add&nbsp;">
                                         </div>
                                         </div>
                                         <span class="help-block alert-danger" style="width:300px">{{ $errors->first('ram_size') }}</span>
                                         {!! Form::close() !!}

                                        <br>

                                             <table class="table table-hover" id="ram">
                                             @foreach($rams as $ram)
                                                  <tr>
                                                          <td>
                                                          {!! Form ::open(['method' => 'POST', 'url' => 'updateRam']) !!}
                                                          <input type="text" name="ramSize" class="form-control input-sm" value="{{$ram->Ram_Size}}" style="width: 250px">
                                                           </td>
                                                           <td>
                                                          <a class="btn btn-default" name="deleteScreen" href="delete/ram/{{$ram->id}}">Delete</a>
                                                          </td>
                                                          <td>
                                                          <input class="btn btn-default" type="submit" name="updateRam" value="Save">
                                                          </td>
                                                          <input type="hidden" name="ram_id" value="{{$ram->id}}">
                                                          {!! Form::close() !!}
                                                          @if ($errors->first('ramSize'))
                                                       {{Session::flash('flash_message_error',$errors->first('ramSize'))}}
                                                      @endif

                                                  </tr>
                                             @endforeach
                                             </table>
                                            {{--<div> {!!$rams->render()!!}</div>--}}
                                   </div>
                             </div>

                           </div>
                           </div>


                    <div class="col-md-6">
                          <div class="panel panel-default">
                                  <div class="panel-heading">Hard Disk Size</div>
                                   <div class="scroll">
                                    <div class="panel-body">
                                          {!! Form ::open(['method' => 'POST', 'action' => ['AddResourcePortion@addHardDisk']]) !!}
                                           <div class="row">
                                           <div class="col-lg-9">
                                          <input type="text" name="disk_size" class="form-control input-sm" value="" style="width: 220px">
                                          </div>
                                          <div class="col-lg-3">
                                          <input type="submit" name="addDisk" class="btn btn-primary" value="Add&nbsp;">
                                          </div>
                                          </div>
                                          <span class="help-block alert-danger" style="width:300px">{{ $errors->first('disk_size') }}</span>
                                          {!! Form::close() !!}
                                          <br>


                                              <table class="table table-hover" id="HardDisk">
                                              @foreach($disks as $disk)
                                                   <tr>
                                                            <td>
                                                           {!! Form ::open(['method' => 'POST', 'url' => 'updateHardDisk']) !!}
                                                           <input type="text" name="diskSize" class="form-control input-sm" value="{{$disk->Disk_Size}}" style="width: 250px">
                                                           </td>
                                                           <td>
                                                            <a class="btn btn-default" name="deleteScreen" href="delete/disk/{{$disk->id}}">Delete</a>
                                                            </td>
                                                            <td>
                                                            <input  class="btn btn-default" type="submit" name="updateDisk" value="Save">
                                                            </td>
                                                           <input type="hidden" name="disk_id" value="{{$disk->id}}">
                                                           {!! Form::close() !!}
                                                            @if ($errors->first('diskSize'))
                                                            {{Session::flash('flash_message_error',$errors->first('diskSize'))}}
                                                            @endif

                                                   </tr>
                                              @endforeach
                                              </table>
                                             {{--<div> {!!$disks->render()!!}</div>--}}
                                    </div>
                              </div>

                               </div>
                               </div>





@stop