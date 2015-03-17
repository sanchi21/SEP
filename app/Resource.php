<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

    protected  $table = 'Resource';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

//    protected $fillable = [
//        'inventory_code'
//];

}
