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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('tipo_vehiculo', 50);
            $table->decimal('precio_hora', 7, 0);
            $table->decimal('precio_media_hora', 7, 0);
            $table->decimal('precio_fraccion_hora', 7, 0);
        });

        DB::table('tarifas')->insert([
            ['tipo_vehiculo' => 'Carro', 'precio_hora' => 3500, 'precio_media_hora' => 3000,  'precio_fraccion_hora' => 2200],
            ['tipo_vehiculo' => 'Motocicleta', 'precio_hora' => 2000, 'precio_media_hora' => 1500, 'precio_fraccion_hora' => 1000 ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifas');
    }
};
