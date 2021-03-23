<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrealertas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prealertas', function (Blueprint $table) {
            $table->string('id_alerta',32);
            $table->string('id_grupo',32);
            $table->string('id_usuario',32);
            $table->string('imagen',500);
            $table->string('asunto',500);
            $table->mediumtext('mensaje');
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
        Schema::dropIfExists('prealertas');
    }
}
