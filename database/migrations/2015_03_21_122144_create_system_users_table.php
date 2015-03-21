<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('username',20);
            $table->string('email',50)->unique();
            $table->string('password', 60);
            $table->string('password_temp', 60);
            $table->string('password_old', 60);
            $table->string('code', 60);
            $table->integer('active');
            $table->integer('role_id');
            $table->rememberToken();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('system_users');
	}

}
