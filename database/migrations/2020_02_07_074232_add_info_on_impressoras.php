<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoOnImpressoras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('impressoras', function (Blueprint $table) {
            //
            $table->string('fila_impressao')
                ->after('ns')
                ->nullable()
                ->default(null);
            $table->string('contrato')
                ->after('fila_impressao')
                ->nullable()
                ->default(null);
            $table->decimal('valor_locacao', 5, 2)
                ->after('contrato')
                ->nullable()
                ->default(null);
                */
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
        Schema::table('impressoras', function (Blueprint $table) {
            //
        });
    }
}
