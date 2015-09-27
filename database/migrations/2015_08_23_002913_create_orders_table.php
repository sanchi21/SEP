<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('invoice_id');
            $table->string('request_id');
            $table->string('payment_method');
            $table->string('order_date');
            $table->string('status');
            $table->double('total');
            $table->string('cheque_number');
            $table->string('pay_description');

		});
	}


	public function down()
	{
		Schema::drop('orders');
	}

}
