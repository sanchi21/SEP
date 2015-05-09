<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectivityreqTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('connectivityreq', function(Blueprint $table)
		{
            $table->string('request_id',100);
            $table->integer('sub_id');
            $table->string('type',100);
            $table->string('protocol',100);
            $table->string('port',100);
            $table->string('sever_name',100);
            $table->string('ip_address',100);
            $table->primary(array('request_id', 'sub_id'));
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
		Schema::drop('connectivityreq');
	}

}
