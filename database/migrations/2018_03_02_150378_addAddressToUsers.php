<?php

use Illuminate\Database\Migrations\Migration;

class AddAddressToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->string('legal_type')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('ico')->nullable();
			$table->string('dic')->nullable();
			$table->string('phone')->nullable();
			$table->string('avatar')->nullable();

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
			$table->dropColumn('legal_type');	
			$table->dropColumn('first_name');	
			$table->dropColumn('last_name');	
			$table->dropColumn('ico');	
			$table->dropColumn('dic');	
			$table->dropColumn('phone');	

		});
	}

}

