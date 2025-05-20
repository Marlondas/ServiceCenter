<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id('id_marca');
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Modificar la tabla vehículos para que use la nueva tabla de marcas
        Schema::table('vehiculos', function (Blueprint $table) {
            // Primero eliminamos la columna marca existente si necesitas mantener datos
            // deberías migrarlos antes de eliminar la columna
            $table->dropColumn('marca');
            
            // Añadimos la nueva columna para la relación
            $table->unsignedBigInteger('id_marca')->after('placa');
            $table->foreign('id_marca')->references('id_marca')->on('marcas');
        });
    }

    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropForeign(['id_marca']);
            $table->dropColumn('id_marca');
            $table->string('marca', 50)->after('placa');
        });

        Schema::dropIfExists('marcas');
    }
};