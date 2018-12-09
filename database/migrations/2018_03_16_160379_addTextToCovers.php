<?php

use Illuminate\Database\Migrations\Migration;

class AddTextToCovers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('banners', function($table)
		{
			$table->string('h1_text')->nullable();
			$table->string('h2_text')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('banners', function($table)
		{
			$table->dropColumn('h1_text');	
			$table->dropColumn('h2_text');

		});

	}

}

