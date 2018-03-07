<?php

use Illuminate\Database\Migrations\Migration;

class ChangeAddressesToJsonOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function($table)
		{
			$table->dropColumn('invoice_address_street');	
			$table->dropColumn('invoice_address_zip');	
			$table->dropColumn('invoice_address_city');	
			$table->dropColumn('invoice_name');	
			$table->dropColumn('invoice_phone');	
			$table->dropColumn('invoice_email');	
			$table->dropColumn('invoice_first_additional');	

			$table->dropColumn('delivery_address_name');	
			$table->dropColumn('delivery_address_street');	
			$table->dropColumn('delivery_address_zip');	
			$table->dropColumn('delivery_address_city');	
			$table->dropColumn('delivery_address_phone');	
			$table->dropColumn('delivery_address_email');	

			$table->json('invoice_address');
	      	$table->json('delivery_address')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function($table)
		{
		});
	}

}

