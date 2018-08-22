<?php

use Illuminate\Database\Migrations\Migration;

class AddDisplayToSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function($table)
		{
			$table->string('display_name')->nullable();	
			$table->timestamps();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function($table)
		{
			$table->dropColumn('display_name');	
		});
	}

}

