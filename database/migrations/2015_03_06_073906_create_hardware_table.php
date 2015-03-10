<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Hardware', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->string('type')->nullable();
            $table->string('description','300')->nullable();
            $table->string('serial_no','50')->nullable();
            $table->string('ip_address','50')->nullable();
            $table->string('make','100')->nullable();
            $table->string('model','100')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_exp')->nullable();
            $table->double('insurance')->nullable();
            $table->double('value')->nullable();

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
		Schema::drop('Hardware');
	}

}
