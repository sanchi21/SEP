<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model {

    protected $table = 'renewal';
    public $timestamps = false;
    //protected $primaryKey = 'id , sid';

    protected $fillable=[
        'id',
        'sid'

    ];

}

