<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HardDisk extends Model {

    protected $table = 'hard_disks';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected function deleteDiskSize($id){

        $status = true;

        $status = DB::table('hard_disks')->where('id', $id)->delete();

        return $status;

    }

}
