<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleaseRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('release_requests', function(Blueprint $table)
		{
            $table->string('req_id',100);
            $table->string('sub_id',100);
            $table->string('item_name',100);
            $table->string('type',100);
            $table->string('project_code',100);
            $table->string('assigned_date',100);
            $table->string('required_upto',100);
            $table->boolean('status');

		});
	}


	public function down()
	{
		Schema::drop('release_requests');
	}

}
