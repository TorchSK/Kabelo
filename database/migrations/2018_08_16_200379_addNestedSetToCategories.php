<?php

use Illuminate\Database\Migrations\Migration;

class AddNestedSetToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
		{
			$table->unsignedInteger('_lft');
			$table->unsignedInteger('_rgt');	
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
			$table->dropColumn('_lft');	
			$table->dropColumn('_rgt');	
		});
	}

}

