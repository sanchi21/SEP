<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Dongle_SIM extends Model {

    protected $table = 'Dongle_SIM';

	protected $fillable = [

        'phone_no',
        'service_provider',
        'data_limit',
        'monthly_rental',
        'location'
    ];

}
