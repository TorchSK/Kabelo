<?php

use Illuminate\Database\Migrations\Migration;

class ChangeOrdersDelivery extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function($table)
		{
			$table->dropColumn('delivery_method');	
			$table->dropColumn('payment_method');
			$table->integer('delivery_method_id')->index()->unsigned();
            $table->foreign('delivery_method_id')->references('id')->on('delivery_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('payment_method_id')->index()->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade')->onUpdate('cascade');
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
		});
	}

}

