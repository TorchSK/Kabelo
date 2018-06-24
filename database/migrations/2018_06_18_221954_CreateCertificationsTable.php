<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCertificationsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('certifications', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('key',10)->unique();
      $table->string('name',50);
      $table->string('desc');

    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('certifications');
  }
}