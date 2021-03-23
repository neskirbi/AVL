<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('id_usuario',32)->unique();;
            $table->string('fbtoken',1300)->default('');
            $table->string('id_grupo',32)->default('');
            $table->string('avatar',1500)->default('');
            $table->string('nombres',150);
            $table->string('apellidos',150);
            $table->string('mail',150)->unique();
            $table->string('pass',50);
            $table->string('direccion',1500);
            $table->string('ubicacion',100)->default('');
            $table->datetime('ult_login');            
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
        Schema::dropIfExists('usuarios');
    }
}
