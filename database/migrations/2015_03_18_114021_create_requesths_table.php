<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequesthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requesths', function(Blueprint $table)
		{
			$table->string('request_id',100);
            $table->date('required_from');
            $table->date('required_upto');
            $table->string('project_id',50);
            $table->integer('user_id');
            $table->integer('request_status');
			$table->timestamps();
            $table->primary('request_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requesths');
	}

}
