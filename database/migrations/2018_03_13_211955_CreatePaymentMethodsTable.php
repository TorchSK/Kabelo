<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentMethodsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('payment_methods', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('key');
      $table->string('name');
      $table->tinyInteger('order')->default(0);
    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('payment_methods');
  }
}