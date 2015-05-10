<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAllocation extends Migration {


	public function up()
	{
		Schema::create('employeeAllocation', function(Blueprint $table)
		{
			$table->string('inventory_code','30');
            $table->string('user_name','30');
            $table->string('resource_type','30');
            $table->string('make','50');
            $table->string('model','50');
            $table->integer('status');
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
		Schema::drop('employeeAllocation');
	}

}
