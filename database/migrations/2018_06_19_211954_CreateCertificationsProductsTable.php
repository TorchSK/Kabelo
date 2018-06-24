<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCertificationsProductsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('certification_product', function(Blueprint $table)
    {
      $table->integer('certification_id')->unsigned()->index();
      $table->foreign('certification_id')->references('id')->on('certifications')->onDelete('cascade')->onUpdate('cascade');
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
    Schema::drop('certification_product');
  }
}