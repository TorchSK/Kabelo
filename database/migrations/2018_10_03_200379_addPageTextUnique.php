<?php

use Illuminate\Database\Migrations\Migration;

class AddPageTextUnique extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page_text', function($table)
		{
			$table->unique( array('page_id','text_id') );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('page_text', function($table)
		{
		});

	}

}

