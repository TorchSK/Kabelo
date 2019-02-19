<?php

use Illuminate\Database\Migrations\Migration;

class AddCarouselsToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->boolean('new_carousel')->default(0);
			$table->boolean('sale_carousel')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function($table)
		{
			$table->dropColumn('new_carousel');	
			$table->dropColumn('sale_carousel');	
		});

	}

}

