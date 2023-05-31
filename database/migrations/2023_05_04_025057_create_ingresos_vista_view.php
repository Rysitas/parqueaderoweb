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
        CREATE VIEW ingresos_vista AS
        SELECT registros.id AS id, vehiculos.placa AS placa, registros.entrada AS entrada, vehiculos.tipo AS tipo, registros.pagado AS pagado
        FROM registros
        JOIN vehiculos ON registros.vehiculo_id = vehiculos.id
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `ingresos_vista`");
    }
};
