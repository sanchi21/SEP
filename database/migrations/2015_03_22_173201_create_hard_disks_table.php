<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardDisksTable extends Migration {
    
	public function up()
	{
		Schema::create('hard_disks', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('Disk_Size','20');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hard_disks');
	}

}
