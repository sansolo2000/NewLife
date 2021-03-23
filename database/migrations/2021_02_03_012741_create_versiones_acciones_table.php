<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionesAccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versiones_acciones', function (Blueprint $table) {
            $table->id('veac_id');
            $table->unsignedBigInteger('vers_id');
            $table->unsignedBigInteger('tiaj_id');
            $table->unsignedBigInteger('user_id');
            $table->string('veac_nombre');
            $table->string('veac_ruta')->nullable();
            $table->timestamp('veac_fecha');
            $table->boolean('veac_activo');
            $table->text('veac_observacion')->nullable();
            $table->timestamps();
        });

        Schema::table('versiones_acciones', function (Blueprint $table) {
            $table->foreign('vers_id')->references('vers_id')->on('versiones');
            $table->foreign('tiaj_id')->references('tiaj_id')->on('tipo_acciones_jiras');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versiones_acciones');
    }
}
