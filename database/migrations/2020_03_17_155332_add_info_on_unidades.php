<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoOnUnidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('unidades', function (Blueprint $table) {
            //
             $table->string('empregadora')
                ->after('name')
                ->nullable()
                ->default(null);
            $table->string('endereco')
                ->after('empregadora')
                ->nullable()
                ->default(null);
            $table->string('cnpj')
                ->after('endereco')
                ->nullable()
                ->default(null);  
            $table->integer('status')
                ->after('cnpj')
                ->nullable()
                ->default(null);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
