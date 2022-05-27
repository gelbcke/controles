<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement('ALTER TABLE ambientes MODIFY aquisicao TIMESTAMP NULL DEFAULT NULL;');

        DB::statement('ALTER TABLE imagems MODIFY version  DECIMAL(15,2);');
/*
        //Atualiza status das revisões anteriores para concluído
        $results = DB::table('ambientes')->select('id','name')->get();

        $i = 1;
        foreach ($results as $result){
            DB::table('ambientes')
                ->where('aquisicao', "0000-00-00 00:00:00")
                ->update(["aquisicao" => NULL]);
            $i++;
        }
*/
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
