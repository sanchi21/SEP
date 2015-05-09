<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class req extends Model {

    protected $table = 'reqs';
   //protected $primaryKey = array('request_id,sub_id');

    protected $fillable=[
        'request_id',
        'sub_id',

    ];

}
