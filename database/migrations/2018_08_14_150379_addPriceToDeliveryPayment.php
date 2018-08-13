<?php

use Illuminate\Database\Migrations\Migration;

class AddPriceToDeliveryPayment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('delivery_method_payment_method', function($table)
		{
			$table->float('price')->default(0);	
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('delivery_method_payment_method', function($table)
		{
			$table->dropColumn('price');	
		});
	}

}

