<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
            $table->string('request_id',100);
            $table->integer('sub_id');
            $table->string('type',100)->nullable();
            $table->primary(array('request_id', 'sub_id'));
            $table->foreign('request_id')->references('request_id')->on('requesths');
            $table->timestamps();

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('files');
	}

}
