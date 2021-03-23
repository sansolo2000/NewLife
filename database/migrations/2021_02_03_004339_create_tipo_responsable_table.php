<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_responsables', function (Blueprint $table) {
            $table->id('tire_id');
            $table->string('tire_nombre');
            $table->integer('tire_indice');
            $table->boolean('tire_activo');
            $table->string('tire_area');
            $table->boolean('tire_asignable');
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
        Schema::dropIfExists('tipo_responsables');
    }
}
