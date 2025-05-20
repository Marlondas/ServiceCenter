<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primero modificamos la columna para que acepte valores NULL temporalmente
        Schema::table('servicios', function (Blueprint $table) {
            $table->enum('tipo_vehiculo', ['carro', 'moto', 'ambos'])->nullable()->change();
        });
        
        // Establecemos valores explícitos para cualquier registro que tenga NULL
        // (aunque no debería haber ninguno debido al default anterior)
        DB::table('servicios')->whereNull('tipo_vehiculo')->update(['tipo_vehiculo' => 'ambos']);
        
        // Finalmente, volvemos a hacer la columna NOT NULL pero sin valor predeterminado
        Schema::table('servicios', function (Blueprint $table) {
            $table->enum('tipo_vehiculo', ['carro', 'moto', 'ambos'])->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Si necesitamos revertir, volvemos a poner el valor predeterminado
        Schema::table('servicios', function (Blueprint $table) {
            $table->enum('tipo_vehiculo', ['carro', 'moto', 'ambos'])->default('ambos')->change();
        });
    }
};