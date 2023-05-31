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
        DB::statement("CREATE VIEW `ingresos_vista` AS select `parqueadero1`.`registros`.`id` AS `id`,`parqueadero1`.`vehiculos`.`placa` AS `placa`,`parqueadero1`.`registros`.`entrada` AS `entrada`,`parqueadero1`.`vehiculos`.`tipo` AS `tipo`,`parqueadero1`.`registros`.`pagado` AS `pagado` from (`parqueadero1`.`registros` join `parqueadero1`.`vehiculos` on(`parqueadero1`.`registros`.`vehiculo_id` = `parqueadero1`.`vehiculos`.`id`))");
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
