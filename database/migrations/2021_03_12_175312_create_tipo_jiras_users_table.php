<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoJirasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_jiras_users', function (Blueprint $table) {
            $table->id('tjus_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tiji_id');
            $table->timestamps();
        });

        Schema::table('tipo_jiras_users', function (Blueprint $table) {
            $table->unique(["user_id", "tiji_id"], 'version_tipo_jira_unique');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tipo_jiras_users');
    }
}
