<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Request', function(Blueprint $table)
		{
			$table->string('request_no','30');
            $table->dateTime('request_date')->nullable();
            $table->string('project_code','30')->nullable();
            $table->string('project_name')->nullable();
            $table->dateTime('p_start_date')->nullable();
            $table->dateTime('p_end_date')->nullable();
            $table->string('HOD','100')->nullable();
            $table->string('client_name')->nullable();
            $table->string('user_ID','20')->nullable();

            $table->primary('request_no');
            $table->foreign('user_ID')
                ->references('user_ID')
                ->on('User')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Request');
	}

}
