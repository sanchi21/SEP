<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model {

    protected $table = 'Server';

	protected $fillable = [

        'classification',
        'no_of_cpu'
    ];

}
