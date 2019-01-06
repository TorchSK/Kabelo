<?php

use Illuminate\Database\Migrations\Migration;

class AddOrdersAndBestsellersToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->boolean('bestseller')->default(0);
            $table->tinyInteger('new_order')->default(0);
            $table->tinyInteger('sale_order')->default(0);
            $table->tinyInteger('bestseller_order')->default(0);

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
			$table->dropColumn('bestseller');	
			$table->dropColumn('new_order');	
			$table->dropColumn('sale_order');	
			$table->dropColumn('bestseller_order');	
		});

	}

}

