<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ratings', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('ratingable_id')->unsigned();
      $table->string('ratingable_type');
      $table->integer('user_id')->unsigned()->index();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->tinyInteger('value');
      $table->string('text')->nullable();
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
    Schema::drop('ratings');
  }
}