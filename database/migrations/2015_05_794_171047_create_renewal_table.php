<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('renewal', function(Blueprint $table)
		{
			$table->string('id');
            $table->string('sid');
            $table->string('name', 100);
            $table->date('req_upto');
            $table->integer('status');
            $table->primary(array('id', 'sid'));
            $table->foreign('id')->references('request_id')->on('requesths');



		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('renewal');
	}

}
