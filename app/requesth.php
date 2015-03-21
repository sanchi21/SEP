<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class requesth extends Model {

	//

    protected $table = 'requesths';
    protected $primaryKey = 'request_id';
    protected $fillable=[

        'required_from',
        'required_upto',
        'project_id',
        'user_id',
        'request_status',

    ];


}
