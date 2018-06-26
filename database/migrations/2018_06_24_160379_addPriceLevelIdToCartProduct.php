<?php

use Illuminate\Database\Migrations\Migration;

class AddPriceLevelIdToCartProduct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cart_product', function($table)
		{
    		$table->integer('price_level_id')->unsigned()->index();
      		$table->foreign('price_level_id')->references('id')->on('price_levels')->onDelete('cascade')->onUpdate('cascade');
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
			$table->dropColumn('price_level_id');	
		});
	}

}

