<?php

use Illuminate\Database\Migrations\Migration;

class AddWidthToCovers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('covers', function($table)
		{
			$table->string('width');
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
			$table->dropColumn('width');	

		});

	}

}

