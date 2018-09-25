<?php

use Illuminate\Database\Migrations\Migration;

class AddUrlToCovers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('covers', function($table)
		{
			$table->string('url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('covers', function($table)
		{
			$table->dropColumn('url');	
		});

	}

}

