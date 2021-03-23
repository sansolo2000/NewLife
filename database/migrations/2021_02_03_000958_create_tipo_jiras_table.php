<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoJirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_jiras', function (Blueprint $table) {
            $table->id('tiji_id');
            $table->string('tiji_nombre');
            $table->string('tiji_sistema');
            $table->integer('tiji_indice');
            $table->boolean('tiji_activo');
            $table->boolean('tiji_servicesdesk');
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
        Schema::dropIfExists('tipo_jiras');
    }
}
