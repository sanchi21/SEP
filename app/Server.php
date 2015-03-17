<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model {

    protected $table = 'Server';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

	protected $fillable = [

        'classification',
        'no_of_cpu'
    ];

}
