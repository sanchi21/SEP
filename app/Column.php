<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model {

    protected $table = 'Columns';
    protected $primaryKey = 'cid';
    public $timestamps = false;

}
