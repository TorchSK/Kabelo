<?php

use Illuminate\Database\Migrations\Migration;

class ChangePriceDeliveryPayment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('delivery_method_payment_method', function($table)
		{
			$table->dropColumn('price');	
		});

		Schema::table('delivery_methods', function($table)
		{
			$table->float('price')->default(0);	
		});

		Schema::table('payment_methods', function($table)
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
			$table->float('price')->default(0);	
		});

		Schema::table('delivery_methods', function($table)
		{
			$table->dropColumn('price');	
		});

		Schema::table('payment_methods', function($table)
		{
			$table->dropColumn('price');	
		});
	}

}

