<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->enum('tipo_vehiculo', ['carro', 'moto'])->default('carro');
        });
    }

    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn('tipo_vehiculo');
        });
    }
};