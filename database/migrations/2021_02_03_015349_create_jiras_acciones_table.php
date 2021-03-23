<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJirasAccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jiras_acciones', function (Blueprint $table) {
            $table->id('jiac_id');
            $table->unsignedBigInteger('jira_id');
            $table->unsignedBigInteger('tiaj_id');
            $table->unsignedBigInteger('user_id');
            $table->string('jiac_descripcion');
            $table->timestamp('jiac_fecha');
            $table->text('jiac_observacion')->nullable();
            $table->string('jiac_ruta')->nullable();
            $table->boolean('jiac_activo');
            $table->timestamps();
        });
        Schema::table('jiras_acciones', function (Blueprint $table) {
            $table->foreign('jira_id')->references('jira_id')->on('jiras');
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
        Schema::dropIfExists('jiras_acciones');
    }
}
