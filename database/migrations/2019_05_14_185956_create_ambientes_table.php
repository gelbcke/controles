<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');
            $table->integer('bloco_id');
            $table->string('name');
            $table->string('sala')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('periodo_revisao_1')->nullable();
            $table->integer('periodo_revisao_2')->nullable();
            $table->integer('periodo_revisao_3')->nullable();
            $table->datetime('prox_revisao_1')->nullable();
            $table->datetime('prox_revisao_2')->nullable();
            $table->datetime('prox_revisao_3')->nullable();
            $table->string('imagem_id')->nullable();
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
        Schema::dropIfExists('ambientes');
    }
}
