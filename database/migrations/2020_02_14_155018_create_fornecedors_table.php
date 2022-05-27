<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')
                ->nullable();
            $table->string('razao_social')
                ->nullable();
            $table->string('cnpj')
                ->nullable();
            $table->string('nome_fantasia');            
            $table->string('tel_1')
                ->nullable();
            $table->string('tel_2')
                ->nullable();
            $table->string('tel_3')
                ->nullable();
            $table->string('email')
                ->nullable();
            $table->string('endereco')
                ->nullable();
            $table->string('cidade')
                ->nullable();
            $table->string('estado')
                ->nullable();
            $table->string('pais')
                ->nullable();
            $table->string('cep')
                ->nullable();
            $table->string('site')
                ->nullable();
            $table->string('obs')
                ->nullable();
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
        Schema::dropIfExists('fornecedors');
    }
}
