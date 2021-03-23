<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jiras', function (Blueprint $table) {
            $table->id('jira_id');
            $table->unsignedBigInteger('tire_id');
            $table->unsignedBigInteger('ties_id');
            $table->unsignedBigInteger('tipr_id');
            $table->unsignedBigInteger('tiji_id');
            $table->unsignedBigInteger('vers_id');
            $table->unsignedBigInteger('user_id');
            $table->string('jira_codigo');
            $table->string('jira_asunto');
            $table->text('jira_descripcion');
            $table->timestamp('jira_fecha');
            $table->boolean('jira_reportado')->nullable();
            $table->boolean('jira_activo');
            $table->timestamps();
        });

        Schema::table('jiras', function (Blueprint $table) {
            $table->unique(["jira_codigo"], 'jira_codigo_unique');
            $table->foreign('tire_id')->references('tire_id')->on('tipo_responsables');
            $table->foreign('ties_id')->references('ties_id')->on('tipo_estados');
            $table->foreign('tipr_id')->references('tipr_id')->on('tipo_prioridades');
            $table->foreign('tiji_id')->references('tiji_id')->on('tipo_jiras');
            $table->foreign('vers_id')->references('vers_id')->on('versiones');
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
        Schema::dropIfExists('jiras');
    }
}
