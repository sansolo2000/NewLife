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
            $table->unsignedBigInteger('jira_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('noji_padre')->nullable();
            $table->string('noji_asunto');
            $table->text('noji_descripcion');
            $table->timestamp('noji_fecha');
            $table->string('noji_ruta')->nullable();
            $table->timestamps();
        });
        Schema::table('notas_jiras', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('jira_id')->references('jira_id')->on('jiras');
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
