<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermosResponsabilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termos_responsabilidades', function (Blueprint $table) {
            $table->bigIncrements('id')->start_from(3000000);
            //$table->increments('contrato')->start_from('3000000');
            $table->string('referencia');
            $table->integer('fpw');
            $table->integer('matricula')->nullable();;
            $table->string('colaborador');
            $table->string('email');
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('rg')->nullable();
            $table->string('vinculo');
            $table->string('cargo')->nullable();
            $table->string('contato')->nullable();
            $table->string('unidade_id');
            $table->string('pat');
            $table->string('ns');
            $table->string('equipamento');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('processador')->nullable();
            $table->string('memoria')->nullable();
            $table->string('hd')->nullable();
            $table->string('itens_add')->nullable();
            $table->string('operadora')->nullable();
            $table->string('num_chip')->nullable();
            $table->integer('responsavel_id');
            $table->integer('gerente_id');
            $table->integer('testemunha_id');
            $table->string('gestor_colab')->nullable();
            $table->timestamp('dt_retirada');
            $table->timestamp('dt_entrega')->nullable();
            $table->timestamp('dt_devolucao')->nullable();
            $table->integer('status')->nullable();
            $table->integer('arquivado');
            $table->string('empresa');
            $table->string('obs')->nullable();
            $table->timestamps();
        });

        // INICIA ID COM VALOR DEFINIDO POR CAUSA DO IMPORT DO EXCEL EXISTENTE
        \DB::statement('ALTER TABLE termos_responsabilidades AUTO_INCREMENT = 3000000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termos_responsabilidades');
    }
}
