<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcurementItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('procurement_items', function(Blueprint $table)
		{
			$table->string('pRequest_no');
            $table->string('vendor_id',20);
            $table->bigInteger('item_no');
            $table->string('description');
            $table->integer('quantity');
            $table->double('price');
            $table->double('total_price');
            $table->double('price_tax');
            $table->string('warranty');

            $table->primary(array('pRequest_no','vendor_id','item_no'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('procurement_items');
	}

}
