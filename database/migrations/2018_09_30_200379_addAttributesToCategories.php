<?php

use Illuminate\Database\Migrations\Migration;

class AddAttributesToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
		{
			$table->string('title')->nullable();
			$table->string('keywords')->nullable();
			$table->string('h1')->nullable();
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
			$table->dropColumn('title');	
			$table->dropColumn('keywords');	
			$table->dropColumn('h1');	

		});
	}

}

