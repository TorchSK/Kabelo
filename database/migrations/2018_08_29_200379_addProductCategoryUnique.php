<?php

use Illuminate\Database\Migrations\Migration;

class AddProductCategoryUnique extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_product', function($table)
		{
			$table->unique( array('product_id','category_id') );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_product', function($table)
		{
		});

	}

}

