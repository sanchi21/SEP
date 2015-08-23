<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPathToProcurementRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('procurement_requests', function(Blueprint $table)
		{
            $table->string('path',300);
            $table->string('filename',225);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('procurement_requests', function(Blueprint $table)
		{
			//
		});
	}

}
