<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class req extends Model {

    protected $table = 'reqs';
   /// protected $primaryKey = array('request_id,sub_id');

    protected $fillable=[
        'sub_id',
        'item',
        'os_version',
        'device_type',
        'model',
        'additional_information',

    ];

}
