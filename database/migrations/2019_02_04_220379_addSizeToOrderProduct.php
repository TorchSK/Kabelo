<?php

use Illuminate\Database\Migrations\Migration;

class AddSizeToOrderProduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_product', function($table)
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
		Schema::table('order_product', function($table)
		{
			$table->dropColumn('sizes');	
		});

	}

}

