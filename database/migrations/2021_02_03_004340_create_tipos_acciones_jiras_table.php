<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposAccionesJirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_acciones_jiras', function (Blueprint $table) {
            $table->id('tiaj_id');
            $table->unsignedBigInteger('ties_id');
            $table->string('tiaj_nombre');
            $table->integer('tiaj_indice')->unique();
            $table->boolean('tiaj_activo');
            $table->string('tiaj_responsable_actual');
            $table->string('tiaj_responsable_siguiente')->nullable();
            $table->string('tiaj_tipo');
            $table->string('tiaj_sucesor')->nullable();
            $table->string('tiaj_estado')->nullable();
            $table->string('tiaj_codigo')->nullable();
            $table->timestamps();     
        });
        Schema::table('tipo_acciones_jiras', function (Blueprint $table) {
            $table->foreign('ties_id')->references('ties_id')->on('tipo_estados');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_acciones_jiras');
    }
}
