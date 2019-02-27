<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',48);
            $table->string('name',48);
            $table->json('columns');
            $table->boolean('active')->default(1);
            $table->string('format',16);
            $table->string('file_name',128);
            $table->string('file_ext',6);
            $table->boolean('periodic',6)->default(1);
            $table->integer('frequency')->default(86400);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_tools');
    }
}
