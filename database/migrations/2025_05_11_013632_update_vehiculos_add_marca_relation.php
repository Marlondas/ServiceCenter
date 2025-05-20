<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Añadir la columna id_marca a vehículos (permitiendo NULL temporalmente)
        if (!Schema::hasColumn('vehiculos', 'id_marca')) {
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->unsignedBigInteger('id_marca')->nullable()->after('placa');
            });
        }

        // 2. Migrar los datos existentes solo si la columna marca existe
        if (Schema::hasColumn('vehiculos', 'marca')) {
            // Obtener todas las marcas únicas de la tabla vehículos
            $marcasUnicas = DB::table('vehiculos')
                ->select('marca')
                ->distinct()
                ->whereNotNull('marca')
                ->get();

            // Por cada marca única, crearla en la tabla de marcas y actualizar los vehículos correspondientes
            foreach ($marcasUnicas as $marcaItem) {
                $nombreMarca = $marcaItem->marca;
                
                // Crear la marca si no existe
                $marca = DB::table('marcas')
                    ->where('nombre', $nombreMarca)
                    ->first();
                
                if (!$marca) {
                    $marcaId = DB::table('marcas')->insertGetId([
                        'nombre' => $nombreMarca,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    $marcaId = $marca->id_marca;
                }
                
                // Actualizar los vehículos con esta marca
                DB::table('vehiculos')
                    ->where('marca', $nombreMarca)
                    ->update(['id_marca' => $marcaId]);
            }

            // 3. Eliminar la columna marca antigua
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->dropColumn('marca');
            });
        }

        // 4. Hacer id_marca NOT NULL y añadir la clave foránea
        // Podemos simplemente crear la clave foránea y si falla no pasa nada
        try {
            Schema::table('vehiculos', function (Blueprint $table) {
                if (Schema::hasColumn('vehiculos', 'id_marca')) {
                    $table->unsignedBigInteger('id_marca')->nullable(false)->change();
                    $table->foreign('id_marca')->references('id_marca')->on('marcas');
                }
            });
        } catch (\Exception $e) {
            // Si la clave foránea ya existe, ignoramos el error
        }
    }

    public function down()
    {
        // 1. Eliminar la clave foránea usando try-catch
        try {
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->dropForeign(['id_marca']);
            });
        } catch (\Exception $e) {
            // Si la clave foránea no existe, ignoramos el error
        }

        // 2. Añadir de nuevo la columna marca si no existe
        if (!Schema::hasColumn('vehiculos', 'marca')) {
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->string('marca', 50)->after('placa')->nullable();
            });

            // 3. Migrar los datos de vuelta
            if (Schema::hasColumn('vehiculos', 'id_marca')) {
                $vehiculos = DB::table('vehiculos')
                    ->join('marcas', 'vehiculos.id_marca', '=', 'marcas.id_marca')
                    ->select('vehiculos.id_vehiculo', 'marcas.nombre')
                    ->get();

                foreach ($vehiculos as $vehiculo) {
                    DB::table('vehiculos')
                        ->where('id_vehiculo', $vehiculo->id_vehiculo)
                        ->update(['marca' => $vehiculo->nombre]);
                }
            }
        }

        // 4. Eliminar la columna id_marca si existe
        if (Schema::hasColumn('vehiculos', 'id_marca')) {
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->dropColumn('id_marca');
            });
        }
    }
};