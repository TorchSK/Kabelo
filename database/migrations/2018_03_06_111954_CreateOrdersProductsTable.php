<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersProductsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_product', function(Blueprint $table)
    {
      $table->integer('order_id')->unsigned()->index();
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
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
    Schema::drop('order_product');
  }
}