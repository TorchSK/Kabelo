<?php

use Illuminate\Database\Migrations\Migration;

class AddIcoToCarts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('carts', function($table)
		{
			$table->boolean('ico_flag')->default(0);	
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('carts', function($table)
		{
			$table->dropColumn('ico_flag');	
		});
	}

}

