<?php

use Illuminate\Database\Migrations\Migration;

class AddActiveToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->boolean('active')->default(1);	
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
		    $table->dropColumn('active');	

		});
	}

}

