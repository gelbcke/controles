<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unidade_id');
            $table->integer('bloco_id')->nullable();
            $table->integer('ambiente_id')->nullable();
            $table->string('image_name');
            $table->date('date_of_creation');
            $table->string('version');
            $table->string('creator');
            $table->string('reviewer')->nullable();
            $table->string('file_name');            
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
        Schema::dropIfExists('imagems');
    }
}
