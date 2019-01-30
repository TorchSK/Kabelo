<?php

use Illuminate\Database\Migrations\Migration;

class AddFooterToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function($table)
		{
			$table->boolean('footer')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pages', function($table)
		{
			$table->dropColumn('footer');	
		});

	}

}

