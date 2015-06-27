<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $table = 'items';
    protected $primaryKey = 'key';
    public $timestamps = false;

}
