<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReqsColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reqs', function(Blueprint $table)
		{
            $table->string('inventory_code',100);
            $table->date('assigned_date');
            $table->string('remarks',400);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reqs', function(Blueprint $table)
		{
            $table->dropColumn('inventory_code');
            $table->dropColumn('assigned_date');
            $table->dropColumn('remarks');
		});
	}

}
