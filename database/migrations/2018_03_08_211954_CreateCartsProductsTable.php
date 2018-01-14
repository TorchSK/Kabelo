<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsProductsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cart_product', function(Blueprint $table)
    {
      $table->integer('cart_id')->unsigned()->index();
      $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
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
    Schema::drop('cart_product');
  }
}