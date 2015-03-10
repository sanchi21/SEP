<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDongleSIMTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Dongle_SIM', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->string('phone_no','10')->nullable();
            $table->string('service_provider','50')->nullable();
            $table->string('data_limit','20')->nullable();
            $table->double('monthly_rental')->nullable();
            $table->string('location','100')->nullable();

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
		Schema::drop('Dongle_SIM');
	}

}
