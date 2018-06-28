<?php

use Illuminate\Database\Migrations\Migration;

class AddCookiesGdprToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->boolean('cookies')->nullable();	
			$table->boolean('gdpr')->default(1);	
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn('cookies');	
		    $table->dropColumn('gdpr');	
		});
	}

}

