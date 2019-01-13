<?php

use Illuminate\Database\Migrations\Migration;

class AddLeafletImageflagToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function($table)
		{
			$table->string('back1')->nullable();
			$table->string('back2')->nullable();
			$table->string('back3')->nullable();
            $table->boolean('thumbnail_flag')->default(1);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function($table)
		{
			$table->dropColumn('back1');	
			$table->dropColumn('back2');	
			$table->dropColumn('back3');	
			$table->dropColumn('thumbnail_flag');	
		});

	}

}

