<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tarifa
 * 
 * @property int $id
 * @property string $tipo_vehiculo
 * @property float $precio_hora
 * @property float $precio_media_hora
 * @property float $precio_fraccion_hora
 *
 * @package App\Models
 */
class Tarifa extends Model
{
	protected $table = 'tarifas';
	public $timestamps = false;

	protected $casts = [
		'precio_hora' => 'float',
		'precio_media_hora' => 'float',
		'precio_fraccion_hora' => 'float'
	];

	protected $fillable = [
		'tipo_vehiculo',
		'precio_hora',
		'precio_media_hora',
		'precio_fraccion_hora'
	];
}
