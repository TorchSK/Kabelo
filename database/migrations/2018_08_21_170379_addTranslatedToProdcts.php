<?php

use Illuminate\Database\Migrations\Migration;

class AddTranslatedToProdcts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->boolean('translated')->nullable();	
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
			$table->dropColumn('translated');	
		});
	}

}

