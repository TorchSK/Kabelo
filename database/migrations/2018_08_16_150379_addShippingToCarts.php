<?php

use Illuminate\Database\Migrations\Migration;

class AddShippingToCarts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('carts', function($table)
		{
			$table->float('shipping_price')->default(0);	
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('carts', function($table)
		{
			$table->dropColumn('shipping_price');	
		});
	}

}

