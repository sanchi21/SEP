<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcMailCCsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proc_mail_c_cs', function(Blueprint $table)
		{
			$table->string('pRequest_no');
            $table->string('user_name');

            $table->primary(array('pRequest_no','user_name'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proc_mail_c_cs');
	}

}
