<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('matricula')->unique()->nullable();
            $table->string('status')->nullable();
            $table->string('telefone')->nullable();
            $table->string('unidade_id')->nullable();
            $table->string('periodo')->nullable();
            $table->string('horario_de_entrada')->nullable();
            $table->string('saida_intervalo')->nullable();
            $table->string('retorno_intervalo')->nullable();
            $table->string('horario_de_saida')->nullable();
            $table->string('cidade')->nullable();
            $table->string('bairro')->nullable();
            $table->string('endereco')->nullable();
            $table->string('tipo_transporte')->nullable();
            $table->string('lideranca')->nullable();
            $table->string('cargo')->nullable();
            $table->string('admissao')->nullable();
            $table->string('rg')->nullable();
            $table->string('cpf')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
