<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceProvider extends Model {

    protected $table = 'service_providers';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected function showAllProviders(){

        $providers = DB::table('service_providers')->get();

        return $providers;

    }

    protected function deleteProvider($id){

        $status = true;

        $status = DB::table('service_providers')->where('id', $id)->delete();

        return $status;

    }

}
