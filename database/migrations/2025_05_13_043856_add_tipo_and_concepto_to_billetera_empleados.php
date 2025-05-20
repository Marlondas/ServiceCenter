<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('billetera_empleados', function (Blueprint $table) {
            // Hacer id_lavada nullable para que los pagos no necesiten estar asociados a una lavada
            $table->unsignedBigInteger('id_lavada')->nullable()->change();
            
            // Añadir campo para diferenciar entre comisiones y pagos
            $table->enum('tipo', ['comision', 'pago'])->default('comision')->after('fecha');
            
            // Añadir campo para concepto/descripción de pagos
            $table->string('concepto')->nullable()->after('tipo');
            
            // Modificar la restricción de clave foránea para id_lavada
            $table->dropForeign(['id_lavada']);
            $table->foreign('id_lavada')->references('id_lavada')->on('lavadas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('billetera_empleados', function (Blueprint $table) {
            // Eliminar los campos añadidos
            $table->dropColumn(['tipo', 'concepto']);
            
            // Volver a hacer id_lavada obligatorio
            $table->unsignedBigInteger('id_lavada')->nullable(false)->change();
            
            // Restaurar la restricción original
            $table->dropForeign(['id_lavada']);
            $table->foreign('id_lavada')->references('id_lavada')->on('lavadas')->onDelete('cascade');
        });
    }
};