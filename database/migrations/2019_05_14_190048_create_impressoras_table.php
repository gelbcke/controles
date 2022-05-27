<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpressorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impressoras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');
            $table->integer('bloco_id');
            $table->integer('ambiente_id');
            $table->string('modelo');
            $table->string('ip')->nullable();
            $table->string('ns')->nullable();
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
        Schema::dropIfExists('impressoras');
    }
}
