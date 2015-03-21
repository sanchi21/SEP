<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class active_users extends Model {


    protected $table = 'active_users';
    protected $fillable = ['username', 'email', 'password'];

}
