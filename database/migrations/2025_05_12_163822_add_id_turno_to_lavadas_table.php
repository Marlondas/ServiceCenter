<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('lavadas', function (Blueprint $table) {
        $table->unsignedBigInteger('id_turno')->nullable();
        $table->foreign('id_turno')->references('id_turno')->on('turnos')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('lavadas', function (Blueprint $table) {
        $table->dropForeign(['id_turno']);
        $table->dropColumn('id_turno');
    });
}
};
