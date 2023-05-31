<?php

use Illuminate\Database\Migrations\Migration;
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
        DB::statement("
        CREATE VIEW vehiculos_no_pagados AS
        SELECT vehiculos.id AS id, vehiculos.placa AS placa, vehiculos.tipo AS tipo, registros.entrada AS entrada, registros.pagado AS pagado, registros.servicios_solicitados AS servicios_solicitados
        FROM vehiculos
        JOIN registros ON vehiculos.id = registros.vehiculo_id
        WHERE registros.pagado = 'no' AND registros.salida IS NULL
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `vehiculos_no_pagados`");
    }
};
