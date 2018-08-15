<?php

use Illuminate\Database\Migrations\Migration;

class AddQtyToOrderProdcts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_product', function($table)
		{
			$table->integer('qty');	
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_product', function($table)
		{
			$table->dropColumn('qty');	
		});
	}

}

