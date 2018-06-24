<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorsProductsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('color_product', function(Blueprint $table)
    {
      $table->integer('color_id')->unsigned()->index();
      $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
      $table->integer('product_id')->unsigned()->index();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

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
    Schema::drop('color_product');
  }
}