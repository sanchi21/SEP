<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class hrequest extends Model {

	//
    protected $fillable=[
        'item',
        'os_version',
        'start_date',
        'end_date',
        'additional_information',
        'project_id',
        'user_id',
        'request_status',

    ];

}
