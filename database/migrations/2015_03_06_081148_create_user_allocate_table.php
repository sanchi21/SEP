<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAllocateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('User_Allocate_Resource', function(Blueprint $table)
		{
			$table->string('user_ID','20');
            $table->string('inventory_code','30');
            $table->dateTime('date_allocated')->nullable();

            $table->primary(['user_ID','inventory_code']);
            $table->foreign('user_ID')
                ->references('user_ID')
                ->on('User')
                ->onDelete('cascade');

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
		Schema::drop('User_Allocate_Resource');
	}

}
