<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRamTable extends Migration {

	public function up()
	{
		Schema::create('rams', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('Ram_Size','10');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rams');
	}

}
