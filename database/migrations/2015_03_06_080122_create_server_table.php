<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Server', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->string('classification','30')->nullable();
            $table->integer('no_of_cpu')->nullable();

            $table->primary('inventory_code');
            $table->foreign('inventory_code')
                ->references('inventory_code')
                ->on('Desktop_Laptop')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Server');
	}

}
