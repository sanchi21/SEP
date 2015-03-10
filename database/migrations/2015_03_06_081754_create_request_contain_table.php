<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestContainTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Request_Contain_Res', function(Blueprint $table)
		{
			$table->string('request_no','30');
            $table->string('inventory_code','30');

            $table->primary(['inventory_code','request_no']);
            $table->foreign('inventory_code')
                ->references('inventory_code')
                ->on('Resource')
                ->onDelete('cascade');

            $table->foreign('request_no')
                ->references('request_no')
                ->on('Request')
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
		Schema::drop('Request_Contain_Res');
	}

}
