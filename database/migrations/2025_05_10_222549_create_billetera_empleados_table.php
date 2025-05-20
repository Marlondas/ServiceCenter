<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('billetera_empleados', function (Blueprint $table) {
            $table->id('id_billetera');
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_lavada');
            $table->decimal('monto_comision', 10, 2);
            $table->date('fecha');
            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
            $table->foreign('id_lavada')->references('id_lavada')->on('lavadas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billetera_empleados');
    }
};