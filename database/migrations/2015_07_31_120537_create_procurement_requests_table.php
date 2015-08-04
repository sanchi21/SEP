<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcurementRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('procurement_requests', function(Blueprint $table)
		{
            $table->string('pRequest_no');
            $table->date('request_date');
            $table->string('reason');
            $table->string('for_appeal');

            $table->primary('pRequest_no');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('procurement_requests');
	}

}
