<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('turnos', function (Blueprint $table) {
            // Primero añadimos la nueva columna
            $table->unsignedBigInteger('id_servicio')->nullable()->after('tipo_servicio');
            // Luego creamos la relación
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
        });
    }

    public function down()
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropForeign(['id_servicio']);
            $table->dropColumn('id_servicio');
        });
    }
};