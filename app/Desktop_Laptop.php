<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Desktop_Laptop extends Model {

    protected $table = 'Desktop_Laptop';

	protected $fillable = [

        'CPU',
        'RAM',
        'hard_disk',
        'OS',
        'previous_user'
    ];

}
