<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeCategoryParameters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

	    Schema::create('category_parameter', function(Blueprint $table)
	    {
    		$table->integer('category_id')->unsigned()->index();
      		$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
      		$table->integer('parameter_id')->unsigned()->index();
      		$table->foreign('parameter_id')->references('id')->on('parameters')->onDelete('cascade')->onUpdate('cascade');
      		$table->boolean('is_filter')->default(1);
	    });

	   	 Schema::create('parameters', function(Blueprint $table)
	    {
	      $table->increments('id');
	      $table->string('key');
	      $table->string('display_key');
	      $table->timestamps();
	    });
		
		Schema::enableForeignKeyConstraints();

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}

