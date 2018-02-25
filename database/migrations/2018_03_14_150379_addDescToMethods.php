<?php

use Illuminate\Database\Migrations\Migration;

class AddDescToMethods extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('delivery_methods', function($table)
		{
			$table->string('desc');
			$table->string('icon');
		});

		Schema::table('payment_methods', function($table)
		{
			$table->string('desc');
			$table->string('icon');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('delivery_methods', function($table)
		{
			$table->dropColumn('desc');	
			$table->dropColumn('icon');	

		});

		Schema::table('payment_methods', function($table)
		{
			$table->dropColumn('desc');	
			$table->dropColumn('icon');	

		});
	}

}

