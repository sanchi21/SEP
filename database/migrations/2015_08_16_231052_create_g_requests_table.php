<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('g_requests', function(Blueprint $table)
		{
            $table->string('request_id',20);
            $table->string('type');
            $table->date('date');
            $table->string('pr_code');
            $table->date('from');
            $table->date('to');
            $table->integer('g_status');

            $table->primary('request_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('g_requests');
	}

}
