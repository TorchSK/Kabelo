<?php

use Illuminate\Database\Migrations\Migration;

class AddPriceToOrderProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_product', function($table)
		{
			$table->float('price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('covers', function($table)
		{
			$table->dropColumn('price');	

		});

	}

}

