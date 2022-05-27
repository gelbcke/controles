<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisaoAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisao_ambientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');   
            $table->integer('bloco_id');
            $table->integer('ambiente_id');
            $table->string('rev_id', 50);
            $table->string('atividades', 1000);
            $table->integer('user_id');
            $table->string('obs')->nullable();
            $table->string('participante', 1000)->nullable();
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
        Schema::dropIfExists('revisao_ambientes');
    }
}
