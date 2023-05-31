<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento', 50);
            $table->enum('tipo_resolucion', ['Autorizacion', 'Habilitacion']);
            $table->string('numero_resolucion', 50);
            $table->date('fecha_autorizacion');
            $table->integer('numero_factura_inicial');
            $table->integer('numero_factura_actual');
            $table->integer('numero_factura_final');
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->string('prefijo_facturacion', 50)->nullable();
            $table->boolean('activa')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};
