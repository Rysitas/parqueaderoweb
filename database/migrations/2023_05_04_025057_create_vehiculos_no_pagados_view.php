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
        DB::statement("CREATE VIEW `vehiculos_no_pagados` AS select `parqueadero1`.`vehiculos`.`id` AS `id`,`parqueadero1`.`vehiculos`.`placa` AS `placa`,`parqueadero1`.`vehiculos`.`tipo` AS `tipo`,`parqueadero1`.`registros`.`entrada` AS `entrada`,`parqueadero1`.`registros`.`pagado` AS `pagado`,`parqueadero1`.`registros`.`servicios_solicitados` AS `servicios_solicitados` from (`parqueadero1`.`vehiculos` join `parqueadero1`.`registros` on(`parqueadero1`.`vehiculos`.`id` = `parqueadero1`.`registros`.`vehiculo_id`)) where `parqueadero1`.`registros`.`pagado` = 'no' and `parqueadero1`.`registros`.`salida` is null");
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
