<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Virtual_Server extends Model {

    protected $table = 'Virtual_Server';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

	protected $fillable = [

        'no_of_cores',
        'host_server'
    ];

}
