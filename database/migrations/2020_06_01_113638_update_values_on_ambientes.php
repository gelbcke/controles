<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateValuesOnAmbientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Atualiza status dos projetores e impressoras
        $results = DB::table('ambientes')->select('id','name')->get();

        $proj    = DB::table('projetors')->get();

        $print   = DB::table('impressoras')->get();

        $i = 1;

        foreach ($results as $result){
            DB::table('ambientes')
                ->wherein('id', $proj->pluck('ambiente_id'))
                ->update(["hv_proj" => "1"]);
            $i++;
        }

        foreach ($results as $result){
            DB::table('ambientes')
                ->wherein('id', $print->pluck('ambiente_id'))
                ->update(["hv_printer" => "1"]);
            $i++;
        }

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
