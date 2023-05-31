<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 * 
 * @property int $id
 * @property string $placa
 * @property string $tipo
 * @property string $dentro
 * @property bool $suscrito
 * 
 * @property Collection|Registro[] $registros
 * @property Collection|Suscripcione[] $suscripciones
 *
 * @package App\Models
 */
class Vehiculo extends Model
{
	protected $table = 'vehiculos';
	public $timestamps = false;

	protected $casts = [
		'suscrito' => 'bool'
	];

	protected $fillable = [
		'placa',
		'tipo',
		'ubicacion',
		'suscrito'
	];

	public function registros()
	{
		return $this->hasMany(Registro::class);
	}

	public function suscripciones()
	{
		return $this->hasMany(Suscripcione::class);
	}
}
