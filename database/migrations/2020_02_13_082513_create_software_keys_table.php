<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('software_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('software_id');
            $table->string('version');
            $table->string('status')
                ->nullable();
            $table->string('key')
                ->nullable();
            $table->string('server')
                ->nullable();
            $table->string('server_port')
                ->nullable();
            $table->string('account')
                ->nullable();
            $table->string('account_password')
                ->nullable();
            $table->string('obs')
                ->nullable();
            $table->string('date_last_order');
            $table->string('supplier_id');
            $table->string('due_date')
                ->nullable();
            $table->string('qt_license')
                ->nullable();
            $table->string('nfe')
                ->nullable();
            $table->string('oc');
                ->nullable();
            $table->string('renovation_period');
            $table->string('install_soft_local');
            $table->string('install_lic_local');
            $table->string('description')
                ->nullable();
            $table->string('nfe_file')
                ->nullable();
            $table->string('contract_file')
                ->nullable();
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
        Schema::dropIfExists('software_keys');
    }
}
