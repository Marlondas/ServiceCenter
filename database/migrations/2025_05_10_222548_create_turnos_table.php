<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id('id_turno');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado', ['pendiente', 'confirmado', 'completado', 'cancelado']);
            $table->unsignedBigInteger('id_vehiculo');
            $table->unsignedBigInteger('id_empleado');
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculos')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turnos');
    }
};