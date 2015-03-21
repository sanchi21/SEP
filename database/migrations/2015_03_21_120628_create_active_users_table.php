<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('active_users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('username',20);
            $table->string('email',50)->unique();
            $table->string('password', 60);
            $table->string('password_temp', 60);
            $table->string('password_old', 60);
            $table->string('code', 60);
            $table->integer('active');
            $table->string('type', 20);
            $table->string('permissions', 20);
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
		Schema::drop('active_users');
	}

}
