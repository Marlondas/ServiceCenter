<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lavadas', function (Blueprint $table) {
            $table->id('id_lavada');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('id_vehiculo');
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_turno');
            $table->string('foto_antes')->nullable();
            $table->string('foto_despues')->nullable();
            $table->integer('calificacion')->nullable();
            $table->text('comentario')->nullable();
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculos')->onDelete('cascade');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
            $table->foreign('id_turno')->references('id_turno')->on('turnos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lavadas');
    }
};