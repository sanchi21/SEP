<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcMailCC extends Model {

    protected $primaryKey = array('pRequest_no','user_name');
    public $timestamps = false;

}
