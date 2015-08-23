
@extends('...master')

@section('content')

<style>
.modal.in {
   display:block;
}
.modal-backdrop {
    z-index: 1080;
    height: 650px;
    /*background-color: #243342;*/
}

.modal-backdrop.in {
    opacity: .75;
    /*filter: alpha(opacity=95);*/
}

.modal-dialog{
top: 25%;
}

</style>

<div style="min-height:550px">

<form method="get">
    <div class="modal-backdrop in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="color: #9A0000">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="hideModal()"><span class="glyphicon glyphicon-remove"></span></button>
                    <h4 class="modal-title" id="myModalLabel">Vendors</h4>
                </div>

                <div class="modal-body">
                    <table width="100%" cellspacing="20px" cellpadding="50px">
                        <tr>
                            <td>No of Vendors</td>
                            <td>
                                <input type="number" name="no_of_vendors" id="no_of_vendors" class="form-control" value="1" min="1">
                            </td>
                        </tr>

                        <tr>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                    </table>
                </div>

                <br>
                <div class="modal-footer">
                    <input type="button" class="btn btn-info" value="Next" name="Next" onclick="javascript:location.href = '/purchase-request/'.concat(document.getElementById('no_of_vendors').value);">
                </div>
            </div>
        </div>
    </div>
</form>

</div>

<script>
function hideModal()
{
document.getElementById('myModal').style.display = "none";
window.location = "home";
}
</script>

@endsection
@stop