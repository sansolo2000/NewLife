<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id('inci_id');
            $table->unsignedBigInteger('jira_id');
            $table->bigInteger('inci_numero');
            $table->string('inci_asunto');
            $table->text('inci_descripcion');
            $table->string('inci_tecnico');
            $table->timestamp('inci_fecha');
            $table->timestamps();
        });

        Schema::table('incidentes', function (Blueprint $table) {
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
        Schema::dropIfExists('incidentes');
    }
}
