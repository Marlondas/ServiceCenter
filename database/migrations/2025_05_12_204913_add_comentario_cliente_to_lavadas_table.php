<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lavadas', function (Blueprint $table) {
            $table->text('comentario_cliente')->nullable()->after('comentario');
        });
    }

    public function down()
    {
        Schema::table('lavadas', function (Blueprint $table) {
            $table->dropColumn('comentario_cliente');
        });
    }
};