
<br>
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('cpu','CPU')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::text('cpu_text',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::label('ram','RAM')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::text('ram_text',null,['class'=>'form-control'])!!}
    </div>

</div>

{{--Hard disk & OS--}}
<br>
<div class="row">

    <div class="col-xs-4 col-md-2">
            {!!Form::label('hard_disk','Hard Disk')!!}
    </div>

    <div class="col-xs-4 col-md-4">
            {!!Form::text('hard_disk_text',null,['class'=>'form-control'])!!}
    </div>

    <div class="col-xs-4 col-md-2">
        {!!Form::label('os','OS')!!}
    </div>

    <div class="col-xs-4 col-md-4">
        {!!Form::text('os_text',null,['class'=>'form-control'])!!}
    </div>

</div>