<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesktopLaptopTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Desktop_Laptop', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->string('CPU','20')->nullable();
            $table->string('RAM','20')->nullable();
            $table->integer('hard_disk')->nullable();
            $table->string('OS','50')->nullable();
            $table->string('previous_user','50')->nullable();

            $table->primary('inventory_code');
            $table->foreign('inventory_code')
                ->references('inventory_code')
                ->on('Hardware')
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
		Schema::drop('Desktop_Laptop');
	}

}
