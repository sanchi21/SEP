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

            //Monitor
            $table->float('screen_size')->nullable();

            //Dongle Sim
            $table->string('phone_no','10')->nullable();
            $table->string('service_provider','50')->nullable();
            $table->string('data_limit','20')->nullable();
            $table->double('monthly_rental')->nullable();
            $table->string('location','100')->nullable();

            //Client Device
            $table->string('device_type')->nullable();
            $table->string('client_name','100')->nullable();

            //Desktop Laptop
            $table->string('CPU','20')->nullable();
            $table->string('RAM','20')->nullable();
            $table->integer('hard_disk')->nullable();
            $table->string('OS','50')->nullable();
            $table->string('previous_user','50')->nullable();

            //Server
            $table->string('classification','30')->nullable();
            $table->integer('no_of_cpu')->nullable();

            //Virtual Server
            $table->integer('no_of_cores')->nullable();
            $table->string('host_server','50')->nullable();

            //Comment
            $table->string('comment','355')->nullable();

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
