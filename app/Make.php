<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class make extends Model {

    protected $table = 'makes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function showAllMakes(){

        $makes = DB::table('makes')->get();

        return $makes;

    }

    protected function deleteMake($id){

        $status = true;

        $status = DB::table('makes')->where('id', $id)->delete();

        return $status;

    }

}
