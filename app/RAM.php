<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RAM extends Model {

    protected $table = 'rams';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected function deleteRamSize($id){

        $status = true;

        $status = DB::table('rams')->where('id', $id)->delete();

        return $status;

    }

}
