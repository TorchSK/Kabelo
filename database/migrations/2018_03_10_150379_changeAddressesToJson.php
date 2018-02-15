<?php

use Illuminate\Database\Migrations\Migration;

class ChangeAddressesToJson extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addresses', function($table)
		{
			$table->dropColumn('type');	
			$table->dropColumn('street');	
			$table->dropColumn('city');	
			$table->dropColumn('zip');	
			$table->dropColumn('phone');	
			$table->dropColumn('state');	
			$table->dropColumn('name');	
			$table->dropColumn('additional');	
	      	$table->json('invoice_address')->nullable();
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
		Schema::table('addresses', function($table)
		{
		});
	}

}

