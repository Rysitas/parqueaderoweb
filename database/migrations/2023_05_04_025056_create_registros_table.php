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
        Schema::create('registros', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('placa', 10);
            $table->integer('vehiculo_id')->index('fk_registros_vehiculos');
            $table->dateTime('entrada');
            $table->dateTime('salida')->nullable();
            $table->enum('pagado', ['si', 'no'])->default('no');
            $table->string('servicios_solicitados')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
};
