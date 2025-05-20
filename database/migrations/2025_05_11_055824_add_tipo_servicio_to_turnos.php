<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->string('tipo_servicio')->after('id_empleado');
            $table->text('comentarios')->nullable()->after('tipo_servicio');
        });
    }

    public function down()
    {
        Schema::table('turnos', function (Blueprint $table) {
            $table->dropColumn(['tipo_servicio', 'comentarios']);
        });
    }
};