<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryParametersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('category_parameters', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('category_id')->unsigned()->index();
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
      $table->string('key');
      $table->string('display_key');
      $table->boolean('is_filter');

      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('category_parameters');
  }
}