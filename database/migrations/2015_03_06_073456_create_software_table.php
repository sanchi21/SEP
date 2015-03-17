<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Software', function(Blueprint $table)
		{
            $table->string('inventory_code','30');
            $table->string('name')->nullable();
            $table->string('vendor')->nullable();
            $table->string('no_of_license')->nullable();

            $table->primary('inventory_code');
            $table->foreign('inventory_code')
                ->references('inventory_code')
                ->on('Resource')
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
		Schema::drop('Software');
	}

}
