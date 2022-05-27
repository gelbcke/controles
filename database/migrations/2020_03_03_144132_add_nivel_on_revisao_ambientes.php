<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNivelOnRevisaoAmbientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /*
        Schema::table('revisao_ambientes', function(Blueprint $table) {
            $table->renameColumn('status', 'rev_status');
        });
*/
        Schema::table('revisao_ambientes', function (Blueprint $table) {
            //
            $table->string('nivel')
                ->after('rev_id')
                ->nullable()
                ->default(null);           
        });

        //Atualiza status das revisões anteriores para concluído
        $results = DB::table('revisao_ambientes')->select('id','rev_id')->get();

        $i = 1;
        foreach ($results as $result){
            DB::table('revisao_ambientes')
                ->whereNull('rev_status')
                ->update([
                    "rev_status" => "Concluído"
            ]);
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
