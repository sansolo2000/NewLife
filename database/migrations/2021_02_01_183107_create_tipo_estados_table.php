<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_estados', function (Blueprint $table) {
            $table->id('ties_id');
            $table->string('ties_nombre');
            $table->string('ties_estado_sd');
            $table->integer('ties_indice');
            $table->boolean('ties_activo');
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
        Schema::dropIfExists('tipo_estados');
    }
}
