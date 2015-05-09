<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Columns', function(Blueprint $table)
		{
            $table->increments('cid');
            $table->string('category');
			$table->string('table_column');
            $table->string('column_type');
            $table->string('column_name');
            $table->string('min');
            $table->string('max');
            $table->string('validation');
            $table->tinyInteger('dropDown');

            $table->foreign('category')
            ->references('category')
            ->on('Types')
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
		Schema::drop('Columns');
	}

}
