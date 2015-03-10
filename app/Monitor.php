<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model {

    protected $table = 'Monitor';

	protected $fillable = [

        'screen_size'
    ];

}
