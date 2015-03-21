<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScreenSize extends Model {

    protected $table = 'screen_sizes';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected function showAllSizes(){

        $sizes = DB::table('screen_sizes')->get();

        return $sizes;

    }

    protected function deleteScreen($id){

        $status = true;

        $status = DB::table('screen_sizes')->where('id', $id)->delete();

        return $status;

    }
}
