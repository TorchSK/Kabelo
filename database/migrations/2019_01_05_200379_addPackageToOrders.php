<?php

use Illuminate\Database\Migrations\Migration;

class AddPackageToOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function($table)
		{
			$table->string('package_number')->nullable();
			$table->string('cancel_text')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function($table)
		{
			$table->dropColumn('package_number');	
			$table->dropColumn('cancel_text');	
		});

	}

}

