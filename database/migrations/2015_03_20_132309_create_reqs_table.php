<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reqs', function(Blueprint $table)
		{
            $table->string('request_id',100);
            $table->integer('sub_id');
            $table->string('item',100)->nullable();
            $table->string('os_version',200)->nullable();
            $table->string('device_type',200)->nullable();
            $table->string('model',200)->nullable();
            $table->string('additional_information',300)->nullable();
            $table->primary(array('request_id', 'sub_id'));
            $table->foreign('request_id')->references('request_id')->on('requesths');
            $table->foreign('');
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
		Schema::drop('reqs');
	}

}
