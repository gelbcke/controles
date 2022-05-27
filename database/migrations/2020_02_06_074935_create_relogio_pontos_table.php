<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelogioPontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relogio_pontos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');
            $table->integer('bloco_id');
            $table->integer('ambiente_id')
                ->nullable();
            $table->string('pat')
                ->nullable();
            $table->string('ns')
                ->nullable();
            $table->string('fabricante')
                ->nullable();
            $table->string('modelo')
                ->nullable();
            $table->string('obs', 100);
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
        Schema::dropIfExists('relogio_pontos');
    }
}
