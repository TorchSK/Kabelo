<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoversTable extends Migration {
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
      $table->float('left')->default(15);
      $table->float('top')->default(30);
      $table->string('h1_font',30)->default('hwt-artz');
      $table->string('h2_font',30)->default('inherit');
      $table->float('h1_size')->default(5);
      $table->float('h2_size')->default(4);
      $table->string('h1_color',40)->default('#FFF');
      $table->string('h2_color',40)->default('#FFF');
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