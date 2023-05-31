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
        Schema::create('tiquetes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('placa', 10);
            $table->dateTime('hora_entrada');
            $table->dateTime('hora_salida')->nullable();
            $table->string('valor_tiempo');
            $table->string('tipo_vehiculo', 50);
            $table->decimal('valor_iva', 20, 0);
            $table->decimal('valor_pagar', 20, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiquetes');
    }
};
