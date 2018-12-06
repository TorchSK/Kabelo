<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannersTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('banners', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('image');
      $table->string('type');
      $table->integer('order')->default(0);
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();

    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('banners');
  }
}