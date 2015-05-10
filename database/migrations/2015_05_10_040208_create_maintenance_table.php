<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('maintenance', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('inventory_code');
            $table->string('remarks');
            $table->date('date');
            $table->double('cost',15,2);
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
		Schema::drop('maintenance');
	}

}
