<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_Device extends Model {

    protected $table = 'Client_Device';

	protected $fillable = [

        'device_type',
        'client_name'
    ];

}
