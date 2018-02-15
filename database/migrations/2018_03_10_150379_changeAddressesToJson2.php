<?php

use Illuminate\Database\Migrations\Migration;

class ChangeAddressesToJson2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addresses', function($table)
		{
			$table->string('type');	
			$table->dropColumn('invoice_address');	
			$table->dropColumn('delivery_address');	
	      	$table->json('address')->nullable();
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

