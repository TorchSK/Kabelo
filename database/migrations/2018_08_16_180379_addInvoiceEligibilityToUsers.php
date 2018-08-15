<?php

use Illuminate\Database\Migrations\Migration;

class AddInvoiceEligibilityToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->boolean('invoice_eligible')->default(0);	
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
			$table->dropColumn('invoice_eligible');	
		});
	}

}

