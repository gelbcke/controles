<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');
            $table->integer('bloco_id');
            $table->integer('ambiente_id');
            $table->integer('projetor_id');
            $table->integer('patrimonio')->nullable();
            $table->string('ns')->nullable();;
            $table->string('infra');
            $table->string('modelo_suporte');
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
        Schema::dropIfExists('projetors');
    }
}
