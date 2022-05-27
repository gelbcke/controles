<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectorInfoProjetorModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetor_modelos', function (Blueprint $table) {
            //
            $table->string('pixels')
                ->after('modelo')
                ->nullable()
                ->default(null);

            $table->string('lumens')
                ->after('pixels')
                ->nullable()
                ->default(null);

            $table->string('max_resolution')
                ->after('lumens')
                ->nullable()
                ->default(null);

            $table->string('lamp_max_time')
                ->after('max_resolution')
                ->nullable()
                ->default(null);

            $table->string('distance_projection')
                ->after('lamp_max_time')
                ->nullable()
                ->default(null);

            $table->string('max_screen_size')
                ->after('distance_projection')
                ->nullable()
                ->default(null);

            $table->string('contrast')
                ->after('max_screen_size')
                ->nullable()
                ->default(null);

            $table->string('color_reproduction')
                ->after('contrast')
                ->nullable()
                ->default(null);

            $table->string('sound')
                ->after('color_reproduction')
                ->nullable()
                ->default(null);

            $table->string('wireless')
                ->after('sound')
                ->nullable()
                ->default(null);

            $table->string('projection_mode')
                ->after('wireless')
                ->nullable()
                ->default(null);

            $table->string('energy_consumption')
                ->after('projection_mode')
                ->nullable()
                ->default(null);

            $table->string('weight')
                ->after('energy_consumption')
                ->nullable()
                ->default(null);

            $table->string('projector_image')
                ->after('weight')
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
        Schema::table('projetor_modelos', function (Blueprint $table) {
            //
        });
    }
}
