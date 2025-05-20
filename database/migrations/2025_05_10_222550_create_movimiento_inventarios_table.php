<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimiento_inventarios', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->enum('tipo', ['entrada', 'salida']);
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad');
            $table->foreign('id_producto')->references('id_producto')->on('inventarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimiento_inventarios');
    }
};