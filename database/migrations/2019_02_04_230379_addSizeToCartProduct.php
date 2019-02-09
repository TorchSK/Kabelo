<?php

use Illuminate\Database\Migrations\Migration;

class AddSizeToCartProduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cart_product', function($table)
		{
			$table->json('sizes')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cart_product', function($table)
		{
			$table->dropColumn('sizes');	
		});

	}

}

