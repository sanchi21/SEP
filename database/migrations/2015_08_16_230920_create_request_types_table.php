<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_types', function(Blueprint $table)
		{
            $table->string('request_type',20);
            $table->string('key',4);
            $table->string('multiple_request',3);
            $table->string('requester_group');
            $table->string('approving_group');

            $table->primary('request_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('request_types');
	}

}
