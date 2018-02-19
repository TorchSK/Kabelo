<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRelationsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_relations', function(Blueprint $table)
    {
      $table->integer('product_id')->unsigned()->index();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
      $table->integer('related_product_id')->unsigned()->index();
      $table->foreign('related_product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
      $table->string('relation_type')
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
    Schema::drop('product_relations');
  }
}