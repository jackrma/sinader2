<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWasteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('detail_id')->references('id')->on('declaration');
            $table->integer('waste_id')->references('id')->on('ler_waste');
            $table->integer('quantity');
            $table->integer('unitm_id')->references('id')->on('concept_detail');
            $table->integer('company_id')->references('id')->on('companies');
            $table->integer('establishment_id')->references('id')->on('establishment');
            $table->integer('process_id')->references('id')->on('concept_detail');
            $table->integer('unitm_id')->references('id')->on('concept_detail');
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
        Schema::dropIfExists('waste_detail');
    }
}
