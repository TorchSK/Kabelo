<?php

use Illuminate\Database\Migrations\Migration;

class AddThumbToFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('files', function($table)
		{
    		$table->integer('thumb_id')->unsigned()->index()->nullable();
      		$table->foreign('thumb_id')->references('id')->on('files')->onDelete('cascade')->onUpdate('cascade');		
      	});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('files', function($table)
		{
			$table->dropColumn('thumb_id');	
		});
	}

}

