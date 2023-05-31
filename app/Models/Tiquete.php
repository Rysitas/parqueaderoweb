<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tiquete
 * 
 * @property int $id
 * @property string $placa
 * @property Carbon $hora_entrada
 * @property Carbon|null $hora_salida
 * @property float $valor_hora
 * @property string $tipo_vehiculo
 * @property float $valor_pagar
 *
 * @package App\Models
 */
class Tiquete extends Model
{
	protected $table = 'tiquetes';
	public $timestamps = false;

	protected $casts = [
		'hora_entrada' => 'datetime',
		'hora_salida' => 'datetime',
		'valor_iva' => 'float',
		'valor_pagar' => 'float'
	];

	protected $fillable = [
		'placa',
		'hora_entrada',
		'hora_salida',
		'valor_tiempo',
		'tipo_vehiculo',
		'valor_iva',
		'valor_pagar'

	];
}
