<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLerWasteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ler_waste', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('chapter_id')->references('id')->on('ler_chapter');
            $table->integer('subchapter_id')->references('id')->on('ler_subchapter');
            $table->string('name');
            $table->string('waste_code');
            $table->string('type');
            $table->string('pp');
            $table->string('active');
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
        Schema::dropIfExists('ler_waste');
    }
}
