<?php

use Illuminate\Database\Migrations\Migration;

class AddSaleToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->boolean('new')->default(0);
			$table->boolean('sale')->default(0);
			$table->integer('sale_price')->nullable();;

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
			Schema::dropIfExists('new');
        	Schema::dropIfExists('sale');
        	Schema::dropIfExists('sale_price');

		});
	}

}

