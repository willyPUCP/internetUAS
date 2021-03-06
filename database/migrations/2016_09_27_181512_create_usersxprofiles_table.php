<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersxprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersxprofiles', function (Blueprint $table) {
            $table->integer('iduser');
            $table->foreign('iduser')->references('IdUsuario')->on('Usuario');
            $table->integer('idprofile');
            $table->foreign('idprofile')->references('IdPerfil')->on('Perfil');
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
        Schema::drop('usersxprofiles');
    }
}
