<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class operating_system extends Model {

	//

    protected $table = 'operating_systems';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function showAllOperatingSystems(){

        $operatingSystems = DB::table('operating_systems')->get();


        return $operatingSystems;

    }


    protected function deleteOS($id){

        $status = true;

        $status = DB::table('operating_systems')->where('id', $id)->delete();

        return $status;

    }

}
