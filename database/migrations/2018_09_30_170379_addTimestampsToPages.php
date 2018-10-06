<?php

use Illuminate\Database\Migrations\Migration;

class AddTimestampsToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function($table)
		{
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
		Schema::table('pages', function($table)
		{
			$table->dropColumn('updated_at');
			$table->dropColumn('created_at');		
		});
	}

}

