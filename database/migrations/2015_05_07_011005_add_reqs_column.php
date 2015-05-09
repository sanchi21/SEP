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
            $table->date('required_from');
            $table->date('required_upto');

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
            $table->dropColumn('required_from');
            $table->dropColumn('required_upto');
		});
	}

}
