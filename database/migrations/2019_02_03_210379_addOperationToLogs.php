<?php

use Illuminate\Database\Migrations\Migration;

class AddOperationToLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('logs', function($table)
		{
			$table->string('operation',100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('logs', function($table)
		{
			$table->dropColumn('operation');	
		});

	}

}

