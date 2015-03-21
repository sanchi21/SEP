<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sfusers', function(Blueprint $table)
		{
            $table->string('request_id',100);
            $table->integer('sub_id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('type',100)->nullable();
            $table->primary(array('request_id', 'sub_id','user_id'));
            $table->foreign('request_id')->references('request_id')->on('requesths');
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
		Schema::drop('sfusers');
	}

}
