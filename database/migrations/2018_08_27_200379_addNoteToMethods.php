<?php

use Illuminate\Database\Migrations\Migration;

class AddNoteToMethods extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('delivery_methods', function($table)
		{
			$table->string('note')->nullable();
		});

		Schema::table('payment_methods', function($table)
		{
			$table->string('note')->nullable();
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
			$table->dropColumn('note');	
		});

		Schema::table('payment_methods', function($table)
		{
			$table->dropColumn('note');	
		});
	}

}

