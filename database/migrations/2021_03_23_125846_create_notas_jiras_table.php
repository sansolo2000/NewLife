<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasJirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_jiras', function (Blueprint $table) {
            $table->id('noji_id');
            $table->bigInteger('noji_padre')->nullable();
            $table->text('noji_descripcion');
            $table->string('noji_ruta')->nullable();
            $table->string('noji_estado');
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
        Schema::dropIfExists('notas_jiras');
    }
}
