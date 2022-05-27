<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHardwareInfoOnAmbientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ambientes', function (Blueprint $table) {
            //
            $table->string('qt_maquinas')
                ->after('tipo')
                ->nullable()
                ->default(null); 
            $table->text('gabinete')
                ->after('qt_maquinas')
                ->nullable()
                ->default(null);    
            $table->text('aquisicao')
                ->after('gabinete')
                ->nullable()
                ->default(null);
            $table->string('processador')
                ->after('aquisicao')
                ->nullable()
                ->default(null);
            $table->string('ram')
                ->after('processador')
                ->nullable()
                ->default(null);
            $table->string('hd')
                ->after('ram')
                ->nullable()
                ->default(null);
            $table->string('gpu')
                ->after('hd')
                ->nullable()
                ->default(null);
            $table->string('gpu_memo')
                ->after('gpu')
                ->nullable()
                ->default(null);
            $table->integer('status')
                ->after('imagem_id')
                ->nullable()
                ->default(null);
            $table->string('hv_proj')
                ->after('gpu_memo')
                ->nullable()
                ->default(null); 
            $table->string('hv_printer')
                ->after('hv_proj')
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
        Schema::table('ambientes', function (Blueprint $table) {
            //
        });
    }
}
