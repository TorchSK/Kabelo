<?php

use Illuminate\Database\Migrations\Migration;

class AddSortPriceToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->float('moc_sort_price')->default(0);	
			$table->float('voc_sort_price')->default(0);	
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
		    $table->dropColumn('moc_sort_price');	
		    $table->dropColumn('voc_sort_price');	

		});
	}

}

