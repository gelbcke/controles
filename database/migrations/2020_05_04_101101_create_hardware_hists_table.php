<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareHistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_hists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ambiente_id');
            $table->string('user_id'); 
            $table->string('qt_maquinas')
                ->nullable()
                ->default(null); 
            $table->text('gabinete')
                ->nullable()
                ->default(null);    
            $table->text('aquisicao')
                ->nullable()
                ->default(null);
            $table->string('processador')
                ->nullable()
                ->default(null);
            $table->string('ram')
                ->nullable()
                ->default(null);
            $table->string('hd')
                ->nullable()
                ->default(null);
            $table->string('gpu')
                ->nullable()
                ->default(null);
            $table->string('gpu_memo')
                ->nullable()
                ->default(null);
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
        Schema::dropIfExists('hardware_hists');
    }
}
