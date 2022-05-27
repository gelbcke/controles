<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityOnRevisaoAmbientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('revisao_ambientes', function (Blueprint $table) {
            //
            $table->string('rev_status')
                ->after('obs')
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
        Schema::table('revisao_ambientes', function (Blueprint $table) {
            //
        });
    }
}
