<?php

use Illuminate\Database\Migrations\Migration;

class AddActiveToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
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
		Schema::table('categories', function($table)
		{
			$table->dropColumn('active');	
		});
	}

}

