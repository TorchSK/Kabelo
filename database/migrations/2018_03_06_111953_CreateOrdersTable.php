<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('user_id')->unsigned()->index()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('status_id')->unsigned()->index();
      $table->foreign('status_id')->references('id')->on('order_statuses')->onDelete('cascade');
      $table->string('delivery_method');
      $table->string('payment_method');
      $table->string('invoice_name');
      $table->string('invoice_phone');
      $table->string('invoice_email');
      $table->string('invoice_address_street');
      $table->string('invoice_address_zip');
      $table->string('invoice_address_city');
      $table->string('delivery_address_name');
      $table->string('delivery_address_street');
      $table->string('delivery_address_zip');
      $table->string('delivery_address_city');
      $table->string('delivery_address_phone');
      $table->string('delivery_address_email');
      $table->string('invoice_first_additional')->nullable();
      $table->timestamp('shipment_date');

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
    Schema::drop('orders');
  }
}