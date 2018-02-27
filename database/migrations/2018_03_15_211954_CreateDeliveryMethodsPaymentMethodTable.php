<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryMethodsPaymentMethodTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('delivery_method_payment_method', function(Blueprint $table)
    {
      $table->integer('delivery_method_id')->unsigned()->index();
      $table->foreign('delivery_method_id')->references('id')->on('delivery_methods')->onDelete('cascade')->onUpdate('cascade');
      $table->integer('payment_method_id')->unsigned()->index();
      $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade')->onUpdate('cascade');

    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('delivery_method_payment_method');
  }
}