<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposVersionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_versiones', function (Blueprint $table) {
            $table->id('tive_id');
            $table->unsignedBigInteger('vers_id');
            $table->unsignedBigInteger('tiji_id');
            $table->timestamps();
        });
        Schema::table('tipos_versiones', function (Blueprint $table) {
            $table->unique(["vers_id", "tiji_id"], 'version_tipo_jira_unique');
            $table->foreign('vers_id')->references('vers_id')->on('versiones');
            $table->foreign('tiji_id')->references('tiji_id')->on('tipo_jiras');
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_versiones');
    }
}
