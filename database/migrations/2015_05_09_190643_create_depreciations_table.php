<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepreciationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('depreciations', function(Blueprint $table)
		{
			$table->string('inventory_code');
            $table->string('method');
            $table->double('residual');
            $table->double('percentage');
            $table->double('year');

            $table->primary('inventory_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('depreciations');
	}

}
