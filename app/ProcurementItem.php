<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model {

    protected $primaryKey = array('pRequest_no','vendor_id','item_no');
    public $timestamps = false;

}
