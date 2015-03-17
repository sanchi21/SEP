<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model {

    protected $table = 'Monitor';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

	protected $fillable = [

        'screen_size'
    ];

}
