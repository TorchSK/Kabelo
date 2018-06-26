<?php

use Illuminate\Database\Migrations\Migration;

class AddQtyToCartProduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cart_product', function($table)
		{
			$table->unsignedInteger('qty');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function($table)
		{
			$table->dropColumn('qty');	
		});
	}

}

