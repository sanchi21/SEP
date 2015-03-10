<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualServerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Virtual_Server', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->integer('no_of_cores')->nullable();
            $table->string('host_server','50')->nullable();

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
		Schema::drop('Virtual_Server');
	}

}
