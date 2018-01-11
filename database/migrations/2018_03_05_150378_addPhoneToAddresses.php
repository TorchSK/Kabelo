<?php

use Illuminate\Database\Migrations\Migration;

class AddPhoneToAddresses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('addresses', function($table)
		{
			$table->string('phone')->nullable();
			$table->string('name')->nullable();
			$table->string('additional')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('addresses', function($table)
		{
			$table->dropColumn('phone');	
			$table->dropColumn('name');	
			$table->dropColumn('ádditional');	
		});
	}

}

