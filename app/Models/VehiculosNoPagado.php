<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehiculosNoPagado
 * 
 * @property int $id
 * @property string $placa
 * @property string $tipo
 * @property Carbon $entrada
 * @property string $pagado
 * @property string|null $servicios_solicitados
 *
 * @package App\Models
 */
class VehiculosNoPagado extends Model
{
	protected $table = 'vehiculos_no_pagados';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'entrada' => 'datetime'
	];

	protected $fillable = [
		'id',
		'placa',
		'tipo',
		'entrada',
		'pagado',
		'servicios_solicitados'
	];
}
