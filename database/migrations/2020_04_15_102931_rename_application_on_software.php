<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameApplicationOnSoftware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('software', function (Blueprint $table) {
            //$table->integer('application')->change();
            $table->renameColumn('application', 'software_list_id');
        });
        Schema::table('software_lists', function (Blueprint $table) {
            $table->renameColumn('application', 'name');
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
